<?php

namespace common\forms;

use common\models\VoucherMaster;
use common\component\Utils as U;
use common\ebl\Constants as C;

class GenerateVoucherForm extends \yii\base\Model {

    public $operator_id;
    public $opt_amount;
    public $cust_amount;
    public $count;
    public $plan_id;
    public $expiry_date;

    public function attributeLabels(): array {
        return [
            "operator_id" => "Franchise",
            "opt_amount" => "Franchise Discount",
            "cust_amount" => "Customer Discount",
            "plan_id" => "Bouquet",
            "expiry_date" => "Expiry Date",
        ];
    }

    public function scenarios() {
        return [
            VoucherMaster::SCENARIO_CREATE => ['operator_id', 'opt_amount', 'cust_amount', 'count', 'plan_id', 'expiry_date']
        ];
    }

    public function rules() {
        return [
            [['operator_id', 'count', 'plan_id', 'expiry_date'], "required"],
            [['opt_amount', 'cust_amount'], "number"],
            ['operator_id', 'exist', 'targetClass' => \common\models\Operator::class, 'targetAttribute' => ['operator_id' => 'id']],
            ['plan_id', 'exist', 'targetClass' => \common\models\PlanMaster::class, 'targetAttribute' => ['plan_id' => 'id']],
            [['operator_id', 'count', 'plan_id'], 'integer'],
            [['expiry_date'], 'date', 'format' => "php:Y-m-d"],
            [['opt_amount', 'cust_amount'], function ($attribute, $params, $validator) {
                    if (empty($this->opt_amount) && empty($this->cust_amount)) {
                        $this->addError($attribute, "Any one value is required");
                    }
                }]
        ];
    }

    public function save() {
        if (!$this->hasErrors()) {
            $count = $this->count;
            while ($count > 0) {
                $code = U::genCouponCode();
                $model = VoucherMaster::findOne(['coupon' => $code]);
                if (!$model instanceof VoucherMaster) {
                    $model = new VoucherMaster(['scenario' => VoucherMaster::SCENARIO_CREATE]);
                    $model->coupon = $code;
                    $model->operator_id = $this->operator_id;
                    $model->opt_amount = empty($this->opt_amount) ? 0 : $this->opt_amount;
                    $model->cust_amount = empty($this->cust_amount) ? 0 : $this->cust_amount;
                    $model->expiry_date = $this->expiry_date;
                    $model->status = C::VOUCHER_ACTIVE;
                    $model->plan_id = $this->plan_id;
                    if ($model->validate() && $model->save()) {
                        $count--;
                    }
                }
            }
            return true;
        }
        return false;
    }

}
