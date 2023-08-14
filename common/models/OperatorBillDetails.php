<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "operator_bill_details".
 *
 * @property int $id
 * @property int $bill_id
 * @property int $operator_id
 * @property int $distributor_id
 * @property string $bill_no
 * @property string $bill_month
 * @property string $bill_start_date
 * @property string $bill_end_date
 * @property int $trans_type
 * @property string|null $trans_type_name
 * @property int|null $product_id
 * @property string|null $product_name
 * @property float|null $per_day_rate
 * @property int $counts
 * @property float|null $amount
 * @property float|null $tax
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property OperatorBill $bill
 */
class OperatorBillDetails extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'operator_bill_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bill_id', 'operator_id', 'distributor_id', 'bill_no', 'bill_month', 'bill_start_date', 'bill_end_date', 'trans_type', 'counts'], 'required'],
            [['bill_id', 'operator_id', 'distributor_id', 'trans_type', 'product_id', 'counts', 'added_by', 'updated_by'], 'integer'],
            [['bill_month', 'bill_start_date', 'bill_end_date', 'added_on', 'updated_on'], 'safe'],
            [['per_day_rate', 'amount', 'tax'], 'number'],
            [['bill_no', 'trans_type_name', 'product_name'], 'string', 'max' => 255],
            [['bill_id'], 'exist', 'skipOnError' => true, 'targetClass' => OperatorBill::className(), 'targetAttribute' => ['bill_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bill_id' => 'Bill ID',
            'operator_id' => 'Operator ID',
            'distributor_id' => 'Distributor ID',
            'bill_no' => 'Bill No',
            'bill_month' => 'Bill Month',
            'bill_start_date' => 'Bill Start Date',
            'bill_end_date' => 'Bill End Date',
            'trans_type' => 'Trans Type',
            'trans_type_name' => 'Trans Type Name',
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'per_day_rate' => 'Per Day Rate',
            'counts' => 'Counts',
            'amount' => 'Amount',
            'tax' => 'Tax',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Bill]].
     *
     * @return \yii\db\ActiveQuery|OperatorBillQuery
     */
    public function getBill() {
        return $this->hasOne(OperatorBill::className(), ['id' => 'bill_id']);
    }

    /**
     * {@inheritdoc}
     * @return OperatorBillDetailsQuery the active query used by this AR class.
     */
    public static function find() {
        return new OperatorBillDetailsQuery(get_called_class());
    }

    public function getOperator() {
        return $this->hasOne(Operator::class, ['id' => 'operator_id']);
    }

    public function getDistributor() {
        return $this->hasOne(Operator::class, ['id' => 'distributor_id']);
    }

}
