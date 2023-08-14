<?php

namespace common\models;

use Yii;
use common\component\Utils as U;

/**
 * This is the model class for table "operator_bill".
 *
 * @property int $id
 * @property int|null $operator_id
 * @property int|null $distributor_id
 * @property string|null $bill_no
 * @property string|null $bill_month
 * @property string|null $start_date
 * @property string|null $end_date
 * @property float|null $opening_amount
 * @property float|null $payment
 * @property string|null $plan_charges
 * @property string|null $debit_charges
 * @property float|null $debit_charges_nt
 * @property string|null $credit_charges
 * @property float|null $credit_charges_nt
 * @property string|null $hardware_charges
 * @property string|null $discount
 * @property float|null $sub_amount
 * @property float|null $sub_amount_tax
 * @property float|null $total_amount
 * @property float|null $total_tax
 * @property float|null $total
 * @property float|null $closing_amount
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property OperatorBillDetails[] $operatorBillDetails
 */
class OperatorBill extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'operator_bill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['operator_id', 'distributor_id', 'added_by', 'updated_by'], 'integer'],
            [['bill_month', 'start_date', 'end_date', 'plan_charges', 'debit_charges', 'credit_charges', 'hardware_charges', 'discount', 'added_on', 'updated_on'], 'safe'],
            [['opening_amount', 'payment', 'debit_charges_nt', 'credit_charges_nt', 'sub_amount', 'sub_amount_tax', 'total_amount', 'total_tax', 'total', 'closing_amount'], 'number'],
            [['bill_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'operator_id' => 'Operator ID',
            'distributor_id' => 'Distributor ID',
            'bill_no' => 'Bill No',
            'bill_month' => 'Bill Month',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'opening_amount' => 'Opening Amount',
            'payment' => 'Payment',
            'plan_charges' => 'Plan Charges',
            'debit_charges' => 'Debit Charges',
            'debit_charges_nt' => 'Debit Charges Nt',
            'credit_charges' => 'Credit Charges',
            'credit_charges_nt' => 'Credit Charges Nt',
            'hardware_charges' => 'Hardware Charges',
            'discount' => 'Discount',
            'sub_amount' => 'Sub Amount',
            'sub_amount_tax' => 'Sub Amount Tax',
            'total_amount' => 'Total Amount',
            'total_tax' => 'Total Tax',
            'total' => 'Total',
            'closing_amount' => 'Closing Amount',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getOperator() {
        return $this->hasOne(Operator::class, ['id' => "operator_id"]);
    }

    public function getDistributor() {
        return $this->hasOne(Operator::class, ['id' => "distributor_id"]);
    }

    /**
     * Gets query for [[OperatorBillDetails]].
     *
     * @return \yii\db\ActiveQuery|OperatorBillDetailsQuery
     */
    public function getOperatorBillDetails() {
        return $this->hasMany(OperatorBillDetails::className(), ['bill_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return OperatorBillQuery the active query used by this AR class.
     */
    public static function find() {
        return new OperatorBillQuery(get_called_class());
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
        $prefix = "{$opt->billedBy->code}-{$fy}";
        $c = CodeSequence::getSequence($prefix);
        return $prefix . "-" . $c;
    }

}
