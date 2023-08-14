<?php

namespace common\models;

use Yii;
use common\component\Utils as U;
/**
 * This is the model class for table "customer_bill".
 *
 * @property int $id
 * @property int|null $customer_id
 * @property int|null $account_id
 * @property int|null $operator_id
 * @property string|null $bill_month
 * @property string|null $bill_start_date
 * @property string|null $bill_end_date
 * @property string|null $bill_no
 * @property float|null $opening
 * @property float|null $payment
 * @property string|null $subscription_charges
 * @property string|null $debit_charges
 * @property float|null $debit_charges_nt
 * @property string|null $credit_charges
 * @property float|null $credit_charges_nt
 * @property string|null $hardware_charges
 * @property string|null $discount
 * @property float|null $discount_nt
 * @property float|null $sub_amount
 * @property float|null $sub_tax
 * @property float|null $closing
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property CustomerAccount $account
 * @property Operator $operator
 */
class CustomerBill extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'customer_bill';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['customer_id', 'account_id', 'operator_id', 'bill_month', 'bill_start_date', 'bill_end_date', 'bill_no', 'opening', 'payment', 'subscription_charges', 'debit_charges', 'debit_charges_nt', 'credit_charges', 'credit_charges_nt', 'hardware_charges', 'discount', 'discount_nt', 'sub_amount', 'sub_tax', 'total', 'closing'],
            self::SCENARIO_CONSOLE => ['customer_id', 'account_id', 'operator_id', 'bill_month', 'bill_start_date', 'bill_end_date', 'bill_no', 'opening', 'payment', 'subscription_charges', 'debit_charges', 'debit_charges_nt', 'credit_charges', 'credit_charges_nt', 'hardware_charges', 'discount', 'discount_nt', 'sub_amount', 'sub_tax', 'total', 'closing'],
            self::SCENARIO_UPDATE => ['customer_id', 'account_id', 'operator_id', 'bill_month', 'bill_start_date', 'bill_end_date', 'bill_no', 'opening', 'payment', 'subscription_charges', 'debit_charges', 'debit_charges_nt', 'credit_charges', 'credit_charges_nt', 'hardware_charges', 'discount', 'discount_nt', 'sub_amount', 'sub_tax', 'total', 'closing'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['customer_id', 'account_id', 'operator_id', 'added_by', 'updated_by'], 'integer'],
            [['bill_month', 'bill_start_date', 'bill_end_date', 'subscription_charges', 'debit_charges', 'credit_charges', 'hardware_charges', 'discount', 'added_on', 'updated_on'], 'safe'],
            [['opening', 'payment', 'debit_charges_nt', 'credit_charges_nt', 'discount_nt', 'sub_amount', 'sub_tax', 'total', 'closing'], 'number'],
            [['bill_no'], 'string', 'max' => 255],
            [['bill_no'], 'unique'],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerAccount::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['operator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'account_id' => 'Account ID',
            'operator_id' => 'Operator ID',
            'bill_month' => 'Bill Month',
            'bill_start_date' => 'Bill Start Date',
            'bill_end_date' => 'Bill End Date',
            'bill_no' => 'Bill No',
            'opening' => 'Opening',
            'payment' => 'Payment',
            'subscription_charges' => 'Subscription Chanrges',
            'debit_charges' => 'Debit Charges',
            'debit_charges_nt' => 'Debit Charges Nt',
            'credit_charges' => 'Credit Charges',
            'credit_charges_nt' => 'Credit Charges Nt',
            'hardware_charges' => 'Hardware Charges',
            'discount' => 'Discount',
            'discount_nt' => 'Discount Nt',
            'sub_amount' => 'Sub Amount',
            'sub_tax' => 'Sub Tax',
            'closing' => 'Closing',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Account]].
     *
     * @return \yii\db\ActiveQuery|CustomerAccountQuery
     */
    public function getAccount() {
        return $this->hasOne(CustomerAccount::className(), ['id' => 'account_id']);
    }

    /**
     * Gets query for [[Account]].
     *
     * @return \yii\db\ActiveQuery|CustomerAccountQuery
     */
    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Operator]].
     *
     * @return \yii\db\ActiveQuery|OperatorQuery
     */
    public function getOperator() {
        return $this->hasOne(Operator::className(), ['id' => 'operator_id']);
    }

    /**
     * {@inheritdoc}
     * @return CustomerBillQuery the active query used by this AR class.
     */
    public static function find() {
        return new CustomerBillQuery(get_called_class());
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->bill_no = !empty($this->bill_no) ? $this->bill_no : $this->genReceiptNo();
        }
        return parent::beforeSave($insert);
    }

    public function genReceiptNo() {
        $opt = Operator::findOne(['id' => $this->operator_id]);
        $fy = U::Fy($this->bill_month);
        $prefix = "{$opt->code}-{$fy}";
        $c = CodeSequence::getSequence($prefix);
        return $prefix . "-" . $c;
    }

}
