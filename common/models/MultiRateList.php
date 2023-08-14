<?php

namespace common\models;

use Yii;
use common\models\PlanMaster;
use common\models\PeriodMaster;

/**
 * Model multi_rate_list property.
 *
 * @property integer $id
 * @property string $rate_code
 * @property integer $plan_id
 * @property integer $period_id
 * @property integer $days
 * @property string $amount
 * @property string $tax
 * @property string $rental
 * @property string $total
 * @property integer $free_days
 * @property string $drp
 * @property integer $policy_id
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 *
 * @property PeriodMaster $period
 * @property PlanMaster $plan
 */
class MultiRateList extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'multi_rate_list';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'rate_code', 'plan_id', 'period_id', 'days', 'amount', 'tax', 'rental', 'total', 'free_days', 'drp', 'added_on', 'updated_on', 'added_by', 'updated_by', 'policy_id'],
            self::SCENARIO_CONSOLE => ['id', 'rate_code', 'plan_id', 'period_id', 'days', 'amount', 'tax', 'rental', 'total', 'free_days', 'drp', 'added_on', 'updated_on', 'added_by', 'updated_by', 'policy_id'],
            self::SCENARIO_UPDATE => ['id', 'rate_code', 'plan_id', 'period_id', 'days', 'amount', 'tax', 'rental', 'total', 'free_days', 'drp', 'added_on', 'updated_on', 'added_by', 'updated_by', 'policy_id'],
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
            [['rate_code', 'plan_id', 'period_id', 'days', 'amount', 'tax', 'drp', 'policy_id'], 'required'],
            [['plan_id', 'period_id', 'days', 'free_days', 'added_by', 'updated_by', 'policy_id'], 'integer'],
            [['amount', 'tax', 'rental', 'total', 'drp'], 'number'],
            [['added_on', 'updated_on'], 'safe'],
            [['rate_code'], 'string', 'max' => 255],
            [['plan_id', 'period_id', 'rate_code'], 'unique', 'targetAttribute' => ['plan_id', 'period_id', 'rate_code'], 'message' => 'The combination of Rate Code, Plan ID and Period ID has already been taken.'],
            [['period_id'], 'exist', 'skipOnError' => true, 'targetClass' => PeriodMaster::className(), 'targetAttribute' => ['period_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlanMaster::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicyAttr() {
        return $this->hasOne(PlanPolicy::className(), ['id' => 'policy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriod() {
        return $this->hasOne(PeriodMaster::className(), ['id' => 'period_id']);
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
        return $retun;
    }

    /**
     * @inheritdoc
     */
    public function fields() {
        $fields = [
            'id',
            'rate_code',
            'plan_id',
            'period_id',
            'days',
            'amount',
            'tax',
            'rental',
            'total',
            'free_days',
            'drp',
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

        return $fields;
    }

    /**
     * @inheritdoc
     * @return MultiRateListQuery the active query used by this AR class.
     */
    public static function find() {
        return (new MultiRateListQuery(get_called_class()));
    }

}
