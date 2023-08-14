<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * Model operator_plan_rates property.
 *
 * @property integer $id
 * @property integer $assoc_id
 * @property integer $operator_id
 * @property integer $type
 * @property string $rate_id
 * @property string $amount
 * @property string $tax
 * @property string $mrp
 * @property string $mrp_tax
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 *
 * @property Operator $operator
 * @property PlanMaster $plan
 * @property StaticipMaster $staticip
 */
class OperatorRates extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'operator_rates';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'assoc_id', 'operator_id', 'type', 'rate_id', 'amount', 'tax', 'mrp', 'mrp_tax', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_CONSOLE => ['id', 'assoc_id', 'operator_id', 'type', 'rate_id', 'amount', 'tax', 'mrp', 'mrp_tax', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_UPDATE => ['id', 'assoc_id', 'operator_id', 'type', 'rate_id', 'amount', 'tax', 'mrp', 'mrp_tax', 'added_on', 'updated_on', 'added_by', 'updated_by'],
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
            [['assoc_id', 'operator_id', 'type', 'added_by', 'updated_by', 'rate_id'], 'integer'],
            [['amount', 'tax', 'mrp', 'mrp_tax'], 'number'],
            [['added_on', 'updated_on'], 'safe'],
            [['assoc_id', 'operator_id', 'type', 'rate_id'], 'unique', 'targetAttribute' => ['assoc_id', 'operator_id', 'type', 'rate_id'], 'message' => 'The combination of Assoc ID, Operator ID, Rate ID and Type has already been taken.'],
            [['operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['operator_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
    public function getStaticip() {
        return $this->hasOne(StaticipMaster::className(), ['id' => 'assoc_id']);
    }
     */
    public function getBouquet() {
        return $this->hasOne(Bouquet::className(), ['id' => 'assoc_id']);
    }

    public function getStaticip() {
        return $this->hasOne(StaticipMaster::className(), ['id' => 'assoc_id']);
    }

    public function getAssocData() {
        return $this->type == C::RATE_TYPE_BOUQUET ? $this->plan : $this->staticip;
    }

    public function getRate() {
        return $this->hasOne(RateMaster::class, ['id' => 'rate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperator() {
        return $this->hasOne(Operator::className(), ['id' => 'operator_id']);
    }

    /**
     * with
     * @return type
     */
    function defaultWith() {
        return [];
    }

    public function getName() {
        return "{$this->bouquet->name} CP: {$this->amount} MRP :{$this->mrp}";
    }

    /**
     * @inheritdoc
     * @return OperatorPlanRatesQuery the active query used by this AR class.
     */
    public static function find() {
        return new OperatorRatesQuery(get_called_class());
    }

    public function getAssocName() {
        return !empty($this->plan) ? $this->plan->name : (!empty($this->staticip) ? $this->staticip->name : NULL);
    }

    public static function getAssignedRates($operator_id, $plan_id, $type = 1) {
        $model = self::find()
                ->andFilterWhere(['operator_id' => $operator_id, 'assoc_id' => $plan_id, 'type' => C::RATE_TYPE_BOUQUET]);
        if ($type == 1) {
            $model->asArray();
        }
        return $model->all();
    }

}
