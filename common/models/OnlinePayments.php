<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * This is the model class for table "online_payments".
 *
 * @property int $id
 * @property int $payment_for
 * @property string $gateway_type
 * @property string $request_data
 * @property string|null $response_data
 * @property string $order_id
 * @property float $amount
 * @property int|null $account_id
 * @property int $operator_id
 * @property int $status
 * @property string|null $meta_data
 * @property int|null $retry_attempts
 * @property int|null $opt_wallet_id
 * @property string|null $opt_receipt_no
 * @property int|null $sub_wallet_id
 * @property string|null $sub_receipt_no
 * @property string|null $added_on
 * @property int|null $added_by
 * @property string|null $updated_on
 * @property int|null $updated_by
 */
class OnlinePayments extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'online_payments';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'],
            self::SCENARIO_CREATE => ['payment_for', 'gateway_type', 'request_data', 'amount', 'operator_id', 'account_id', 'meta_data', 'order_id'],
            self::SCENARIO_CONSOLE => ['payment_for', 'gateway_type', 'request_data', 'amount', 'operator_id', 'account_id', 'meta_data', 'order_id'],
            self::SCENARIO_UPDATE => ['status', 'retry_attempts', 'opt_wallet_id', 'sub_wallet_id', 'opt_receipt_no', 'sub_receipt_no'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['payment_for', 'gateway_type', 'request_data', 'amount', 'operator_id'], 'required'],
            [['payment_for', 'account_id', 'operator_id', 'status', 'retry_attempts', 'opt_wallet_id', 'sub_wallet_id', 'added_by', 'updated_by'], 'integer'],
            [['request_data', 'response_data', 'meta_data', 'added_on', 'updated_on'], 'safe'],
            [['amount'], 'number'],
            [['gateway_type', 'order_id', 'opt_receipt_no', 'sub_receipt_no'], 'string', 'max' => 255],
            [['order_id'], 'unique'],
        ];
    }

    public function beforeSave($insert) {
        if ($insert) {
            $opt = Operator::findOne(['id' => $this->operator_id]);
            $prefix = ($opt instanceof Operator) ? $opt->code : C::ONLINE_PAYMENT_PFX;
            $this->order_id = empty($this->order_id) ? $this->generateCode($prefix, true) : $this->order_id;
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'payment_for' => 'Payment For',
            'gateway_type' => 'Gateway Type',
            'request_data' => 'Request Data',
            'response_data' => 'Response Data',
            'order_id' => 'Order ID',
            'amount' => 'Amount',
            'account_id' => 'Account ID',
            'operator_id' => 'Operator ID',
            'status' => 'Status',
            'meta_data' => 'Meta Data',
            'retry_attempts' => 'Retry Attempts',
            'opt_wallet_id' => 'Opt Wallet ID',
            'opt_receipt_no' => 'Opt Receipt No',
            'sub_wallet_id' => 'Sub Wallet ID',
            'sub_receipt_no' => 'Sub Receipt No',
            'added_on' => 'Added On',
            'added_by' => 'Added By',
            'updated_on' => 'Modified On',
            'updated_by' => 'Modified By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return OnlinePaymentsQuery the active query used by this AR class.
     */
    public static function find() {
        return new OnlinePaymentsQuery(get_called_class());
    }

    public function processPayments() {
        switch ($this->payment_for) {
            case C::PAY_FOR_SUB:

                break;
            case C::PAY_FOR_OPT:
                $this->optWalletRecharge();
                break;
            default:
                break;
        }
    }

    public function optWalletRecharge() {
        $model = OperatorWallet::findOne(['receipt_no' => $this->order_id, 'operator_id' => $this->operator_id]);
        if (!$model instanceof OperatorWallet) {
            $model = new OperatorWallet(['scenario' => OperatorWallet::SCENARIO_CREATE]);
            $model->cr_operator_id = $this->operator_id;
            $model->operator_id = $this->operator_id;
            $model->amount = $this->amount;
            $model->tax = 0;
            $model->receipt_no = $this->order_id;
            $model->trans_type = C::TRANS_CR_OPERATOR_ONLINE_WALLET_RECHARGE;
            $model->remark = "Wallet recharged with amount Rs{$model->amount} on {$this->added_on}";
            $model->meta_data = [
                "pay_mode" => C::LABEL_PAY_MODE[C::PAY_MODE_PAYMENT_GATEWAY],
                'instrument_nos' => $this->order_id,
                'instrument_date' => date("Y-m-d", strtotime($this->added_on)),
                "instrument_name" => $this->gateway_type
            ];
            if ($model->validate() && $model->save()) {
                OnlinePayments::updateAll(['opt_wallet_id' => $model->id, 'opt_receipt_no' => $model->receipt_no],
                        ['id' => $this->id]);
                return true;
            }
        }
        return false;
    }

    public function getOperator() {
        return $this->hasOne(Operator::class, ['id' => 'operator_id']);
    }

    public function getAccount() {
        return $this->hasOne(CustomerAccount::class, ['id' => 'account_id']);
    }

    public function getOperatorWallet() {
        return $this->hasOne(OperatorWallet::class, ['id' => 'opt_wallet_id']);
    }

}
