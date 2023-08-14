<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "account_plans".
 *
 * @property int $id
 * @property int $account_id
 * @property int $nas_id
 * @property int $operator_id
 * @property string $activation_date
 * @property string $deactivation_date
 * @property int $is_refundable
 * @property int $plan_id
 * @property int $plan_name
 * @property int $plan_type
 * @property array $meta_data
 * @property int $status
 * @property string $amount
 * @property string $tax
 * @property string $mrp
 * @property string $mrp_tax
 * @property string $refund_amount
 * @property string $refund_tax
 * @property string $refund_mrp
 * @property string $refund_mrp_tax
 * @property array $history
 * @property string $added_on
 * @property string $updated_on
 * @property int $added_by
 * @property int $updated_by
 *
 * @property Account $account
 * @property Operator $operator
 * @property PlanMaster $plan
 */
class AccountPlans extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'account_plans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['account_id', 'nas_id', 'operator_id', 'is_refundable', 'plan_id', 'plan_type', 'status', 'added_by', 'updated_by'], 'integer'],
            [['nas_id', 'operator_id', 'activation_date', 'deactivation_date', 'plan_name', 'plan_id', 'plan_type', 'status', 'amount', 'tax', 'mrp', 'mrp_tax'], 'required'],
            [['activation_date', 'deactivation_date', 'meta_data', 'history', 'added_on', 'updated_on'], 'safe'],
            [['amount', 'tax', 'mrp', 'mrp_tax', 'refund_amount', 'refund_tax', 'refund_mrp', 'refund_mrp_tax'], 'number'],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['operator_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlanMaster::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['account_id', 'nas_id', 'operator_id', 'activation_date', 'deactivation_date', 'is_refundable', 'plan_id', 'plan_name', 'plan_type', 'meta_data', 'status', 'amount', 'per_day_amount', 'tax', 'mrp', 'per_day_mrp', 'mrp_tax', 'refund_amount', 'refund_tax', 'refund_mrp', 'refund_mrp_tax', 'history'],
            self::SCENARIO_CONSOLE => ['account_id', 'nas_id', 'operator_id', 'activation_date', 'deactivation_date', 'is_refundable', 'plan_id', 'plan_name', 'plan_type', 'meta_data', 'status', 'amount', 'per_day_amount', 'tax', 'mrp', 'per_day_mrp', 'mrp_tax', 'refund_amount', 'refund_tax', 'refund_mrp', 'refund_mrp_tax', 'history'],
            self::SCENARIO_UPDATE => ['account_id', 'nas_id', 'operator_id', 'activation_date', 'deactivation_date', 'is_refundable', 'plan_id', 'plan_name', 'plan_type', 'meta_data', 'status', 'amount', 'per_day_amount', 'tax', 'mrp', 'per_day_mrp', 'mrp_tax', 'refund_amount', 'refund_tax', 'refund_mrp', 'refund_mrp_tax', 'history'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'nas_id' => 'Nas ID',
            'operator_id' => 'Operator ID',
            'activation_date' => 'Activation Date',
            'deactivation_date' => 'Deactivation Date',
            'is_refundable' => 'Is Refundable',
            'plan_id' => 'Plan ID',
            'plan_name' => 'Plan Name',
            'plan_type' => 'Plan Type',
            'meta_data' => 'Meta Data',
            'status' => 'Status',
            'amount' => 'Amount',
            'tax' => 'Tax',
            'mrp' => 'Mrp',
            'mrp_tax' => 'Mrp Tax',
            'refund_amount' => 'Refund Amount',
            'refund_tax' => 'Refund Tax',
            'refund_mrp' => 'Refund Mrp',
            'refund_mrp_tax' => 'Refund Mrp Tax',
            'history' => 'History',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount() {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperator() {
        return $this->hasOne(Operator::className(), ['id' => 'operator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan() {
        return $this->hasOne(PlanMaster::className(), ['id' => 'plan_id']);
    }

    /**
     * {@inheritdoc}
     * @return AccountPlansQuery the active query used by this AR class.
     */
    public static function find() {
        return new AccountPlansQuery(get_called_class());
    }

}
