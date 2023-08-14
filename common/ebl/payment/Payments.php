<?php

namespace common\ebl\payment;

use yii\helpers\Url;
use common\component\Utils as U;
use common\models\CustomerAccount;
use common\models\Operator;
use common\models\OnlinePayments;
use common\ebl\Constants as C;

class Payments extends \yii\base\Model {

    use \common\ebl\ModelTraits;

    public $gateway;
    public $returnUrl;
    public $reconcileUrl;
    public $gatewayUrl;
    public $isSubscriber;
    public $orderId;
    public $gatewayObj;
    public $userId;
    public $amount;
    public $account_id;
    public $operator_id;
    public $meta_data;
    public $remark;
    public $code;

    public function __construct($config = []) {
        parent::__construct($config);
        $this->returnUrl = urldecode(Url::toRoute(['payment/gw-res', 'pg' => $this->gateway], TRUE));
    }

    public function generateUserData() {
        $data = [];
        if ($this->isSubscriber) {
            $model = CustomerAccount::findOne(['id' => $this->userId]);
            if ($model instanceof CustomerAccount) {
                $this->operator_id = $model->operator_id;
                $this->account_id = $model->id;
                $this->code = $model->operator->code;
                $data = [
                    "name" => $model->customer->name,
                    "mobileno" => $model->customer->mobile_no,
                    "email" => $model->customer->email,
                    "username" => $model->username,
                    "operator_id" => $model->operator_id,
                    "code" => $model->operator->code,
                    "address" => !empty($model->customer->billing_address) ? $model->customer->billing_address : $model->customer->address,
                ];
            }
        } else {
            $model = Operator::findOne(['id' => $this->userId]);
            if ($model instanceof Operator) {
                $this->code = $model->code;
                $this->operator_id = $model->id;
                $this->account_id = 0;

                $data = [
                    "name" => $model->name,
                    "mobileno" => $model->mobile_no,
                    "email" => $model->email,
                    "username" => $model->username,
                    "code" => $model->code,
                    "operator_id" => $model->id,
                    "address" => $model->address
                ];
            }
        }
        return $data;
    }

    public function generateOrderId($id) {
        $opt = Operator::findOne(['id'=>$id]);
        return $this->generateCode($opt->code, true);
    }

    public function initiateTransaction() {
        $this->orderId = $this->generateOrderId($this->operator_id);
        $model = OnlinePayments::findOne(['order_id' => $this->orderId]);
        if (!$model instanceof OnlinePayments) {
            $request = $this->requestHandler();
            $model = new OnlinePayments(['scenario' => OnlinePayments::SCENARIO_CREATE]);
            $model->payment_for = $this->isSubscriber;
            $model->gateway_type = $this->gateway;
            $model->request_data = $request;
            $model->order_id = $this->orderId;
            $model->amount = $this->amount;
            $model->account_id = $this->account_id;
            $model->operator_id = $this->operator_id;
            $model->status = C::ONLINE_PAYMENT_PENDING;
            $model->meta_data = $this->meta_data;
            if ($model->validate() && $model->save()) {
                return $request;
            }
            return false;
        }
    }

    public function processTransaction(Array $data) {
        if (!empty($data)) {
            $model = OnlinePayments::findOne(['order_id' => $data['order_id']]);
            if ($model instanceof OnlinePayments) {
                $model->scenario = OnlinePayments::SCENARIO_UPDATE;
                $model->status = $data['order_status'];
                $model->response_data = $data['resp'];
                if ($model->validate() && $model->save()) {
                    $model->processPayments();
                    return $model;
                }
            }
        }
        return false;
    }

}
