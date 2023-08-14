<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * This is the model class for table "wallet_transaction".
 *
 * @property int $id
 * @property int $operator_id
 * @property int $customer_id
 * @property int $account_id
 * @property string $trans_id
 * @property int $trans_type
 * @property number $amount
 * @property number $tax
 * @property string $receipt_no
 * @property number $balance
 * @property string $remark
 * @property string $meta_data
 * @property string $cancel_id
 * @property string $start_date
 * @property string $end_date
 * @property string $remark
 * @property string $added_on
 * @property string $updated_on
 * @property int $added_by
 * @property int $updated_by
 *
 * @property Wallet[] $wallets
 * @property Customer $customer
 */
class CustomerWallet extends \common\models\BaseModel {

    public $plans_amount;
    public $debit_amount;
    public $credit_amount;
    public $plans_tax;
    public $credit_tax;
    public $debit_tax;
    public $credit_nt_amount;
    public $payment_amount;
    public $debit_nt_amount;
    public $stmonth;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'customer_wallet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['operator_id', 'customer_id', 'account_id', 'username', 'type'], 'required'],
            [['operator_id', 'customer_id', 'account_id', 'type', 'item_id', 'added_by', 'updated_by', 'trans_id'], 'integer'],
            [['amount', 'tax', 'mrp', 'mrp_tax', 'per_day_rate'], 'number'],
            [['start_date', 'end_date', 'added_on', 'updated_on', 'start_date', 'end_date', 'trans_id', 'trans_grp'], 'safe'],
            [['username', 'item_name', 'remark'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['subscriber_id', 'account_id', 'operator_id', 'trans_type', 'amount', 'tax', 'receipt_no', 'balance', 'remark', 'meta_data', 'cancel_id', 'start_date', 'end_date', 'trans_id', 'trans_grp'],
            self::SCENARIO_CONSOLE => ['subscriber_id', 'account_id', 'operator_id', 'trans_type', 'amount', 'tax', 'receipt_no', 'balance', 'remark', 'meta_data', 'cancel_id', 'start_date', 'end_date', 'trans_id', 'trans_grp'],
            self::SCENARIO_UPDATE => ['subscriber_id', 'account_id', 'operator_id', 'trans_type', 'amount', 'tax', 'receipt_no', 'balance', 'remark', 'meta_data', 'cancel_id', 'start_date', 'end_date', 'trans_id', 'trans_grp'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'operator_id' => 'Operator ID',
            'customer_id' => 'Customer ID',
            'account_id' => 'Account ID',
            'username' => 'Username',
            'type' => 'Type',
            'amount' => 'Amount',
            'tax' => 'Tax',
            'mrp' => 'Mrp',
            'mrp_tax' => 'Mrp Tax',
            'item_id' => 'Item ID',
            'item_name' => 'Item Name',
            'per_day_rate' => 'Per Day Rate',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'trans_id' => "Plan",
            'remark' => 'Remark',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['id' => 'subscriber_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount() {
        return $this->hasOne(CustomerAccount::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountPlan() {
        return $this->hasOne(CustomerAccountBouquet::className(), ['id' => 'transaction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperator() {
        return $this->hasOne(Operator::className(), ['id' => 'operator_id']);
    }

    /**
     * {@inheritdoc}
     * @return WalletTransactionQuery the active query used by this AR class.
     */
    public static function find() {
        return new CustomerWalletQuery(get_called_class());
    }

    public function afterSave($insert, $changeAttributes) {
        if ($insert) {
            $acc = CustomerAccount::findOne(["id" => $this->account_id]);
            $balance = in_array($this->trans_type, C::TRANSACTION_TYPE_SUB_CREDIT) ?
                    $acc->balance + $this->amount + $this->tax : $acc->balance - ($this->amount + $this->tax);
            $receipt_no = $this->genReceiptNo($this->trans_type);
            self::updateAll(['receipt_no' => $receipt_no, 'balance' => $balance], ['id' => $this->id]);
            if (in_array($this->trans_type, C::TRANSACTION_RECONSILE_RECONSILE) && SUBSCRIBER_RECONCILIATION) {
                $this->addToReconcile();
            }
        }
        parent::afterSave($insert, $changeAttributes);
    }

    public function genReceiptNo($t) {
        $p = \common\component\Utils::getValuesFromArray(C::LABEL_TRANS_PREFIX, $t);
        $p = !empty($p) ? $p :
                (in_array($t, C::TRANSACTION_TYPE_SUB_CREDIT) ? C::PREFIX_CREDIT :
                C::PREFIX_DEBIT);
        $c = CodeSequence::getSequence($p);
        return $p . $c;
    }

    public function addToReconcile() {
       
        $model = OptPaymentReconsile::findOne(['receipt_no' => $this->receipt_no, 'wallet_id' => $this->id]);
        if (!$model instanceof OptPaymentReconsile) {
            $model = new OptPaymentReconsile(['scenario' => self::SCENARIO_CREATE]);
            $model->inst_no = !empty($this->meta_data['instrument_nos']) ? $this->meta_data['instrument_nos'] : $this->receipt_no;
            $model->inst_date = $this->meta_data['instrument_date'];
            $model->bank = $this->meta_data['instrument_name'];
            $model->receipt_no = $this->receipt_no;
            $model->wallet_id = $this->id;
            $model->amount = $this->amount;
            $model->tax = empty($this->tax) ? 0 : $this->tax;
            $model->status = C::INST_PENDING;
            $model->remark = $this->remark;
            if ($model->validate() && $model->save()) {
                return true;
            }
        }
        return false;
    }

}
