<?php

namespace common\models;

use Yii;

/**
 * Model assigned_rate_list property.
 *
 * @property integer $id
 * @property integer $operator_id
 * @property string $rate_code
 * @property integer $plan_id
 * @property integer $period_id
 * @property integer $days
 * @property integer $free_days
 * @property string $amount
 * @property string $tax
 * @property string $rental
 * @property string $total
 * @property string $mrp
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 *
 * @property Operator $operator
 * @property PlanMaster $plan
 */
class AssignedRateList extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'assigned_rate_list';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'operator_id', 'rate_code', 'plan_id', 'period_id', 'days', 'free_days', 'amount', 'tax', 'rental', 'total', 'mrp', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_CONSOLE => ['id', 'operator_id', 'rate_code', 'plan_id', 'period_id', 'days', 'free_days', 'amount', 'tax', 'rental', 'total', 'mrp', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_UPDATE => ['id', 'operator_id', 'rate_code', 'plan_id', 'period_id', 'days', 'free_days', 'amount', 'tax', 'rental', 'total', 'mrp', 'added_on', 'updated_on', 'added_by', 'updated_by'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) {

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['operator_id', 'plan_id', 'period_id', 'days', 'free_days', 'added_by', 'updated_by'], 'integer'],
            [['rate_code', 'plan_id', 'period_id', 'days', 'amount', 'tax'], 'required'],
            [['amount', 'tax', 'rental', 'total', 'mrp'], 'number'],
            [['added_on', 'updated_on'], 'safe'],
            [['rate_code'], 'string', 'max' => 255],
            [['rate_code', 'operator_id', 'plan_id', 'period_id'], 'unique', 'targetAttribute' => ['rate_code', 'operator_id', 'plan_id', 'period_id'], 'message' => 'The combination of Operator ID, Rate Code, Plan ID and Period ID has already been taken.'],
            [['operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['operator_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlanMaster::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
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
     * with
     * @return type
     */
    function defaultWith() {
        return [];
    }

    static function extraFieldsWithConf() {
        $retun = parent::extraFieldsWithConf();
        $retun['operator_lbl'] = 'operator';
        return $retun;
    }

    /**
     * @inheritdoc
     */
    public function fields() {
        $fields = [
            'id',
            'operator_id',
            'rate_code',
            'plan_id',
            'period_id',
            'days',
            'free_days',
            'amount',
            'tax',
            'rental',
            'total',
            'mrp',
            'added_on',
            'updated_on',
            'added_by',
            'updated_by',
        ];

        return array_merge(parent::fields(), $fields);
    }

    /**
     * @inheritdoc
     */
    public function extraFields() {
        $fields = parent::extraFields();

        $fields['operator_lbl'] = function() {
            return $this->operator ? $this->operator->name : null;
        };
        return $fields;
    }

    /**
     * @inheritdoc
     * @return AssignedRateListQuery the active query used by this AR class.
     */
    public static function find() {
        return new AssignedRateListQuery(get_called_class());
    }

}
