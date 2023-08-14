<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;
use common\component\Utils as U;

/**
 * This is the model class for table "staticip_policy".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $days
 * @property int $months
 * @property int $is_refundable
 * @property string $amount
 * @property string $amount_tax
 * @property string $mrp
 * @property string $mrp_tax
 * @property int $status
 * @property string $added_on
 * @property string $updated_on
 * @property int $added_by
 * @property int $updated_by
 *
 * @property OperatorStaticipAssoc[] $operatorStaticipAssocs
 */
class StaticipPolicy extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'staticip_policy';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['name', 'code', 'days', 'months', 'is_refundable', 'amount', 'amount_tax', 'mrp', 'mrp_tax', 'status'],
            self::SCENARIO_CONSOLE => ['name', 'code', 'days', 'months', 'is_refundable', 'amount', 'amount_tax', 'mrp', 'mrp_tax', 'status'],
            self::SCENARIO_UPDATE => ['name', 'code', 'days', 'months', 'is_refundable', 'amount', 'amount_tax', 'mrp', 'mrp_tax', 'status'],
        ];
    }

    public function beforeValidate() {
        if ($this->scenario == self::SCENARIO_CREATE) {
            $this->code = empty($this->code) ? $this->generateCode(C::PREFIX_STATICPOLICY) : $this->code;
            $this->amount_tax = U::calculateTax($this->amount);
            $this->mrp_tax = U::calculateTax($this->mrp);
        }

        return parent::beforeValidate();
    }

    public function afterSave($insert, $changedAttributes) {
        $keys = array_keys($changedAttributes);
        if (array_intersect($keys, ['amount', 'days', 'months'])) {
            OperatorStaticipAssoc::updateAll([
                "amount" => $this->amount, "amount_tax" => $this->amount_tax, 'days' => $this->days, "months" => $this->months,
                "is_refundable" => $this->is_refundable
                    ], ['staticip_policy_id' => $this->id]);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'status'], 'required'],
            [['days', 'months', 'is_refundable', 'status', 'added_by', 'updated_by'], 'integer'],
            [['amount', 'amount_tax', 'mrp', 'mrp_tax'], 'number'],
            [['added_on', 'updated_on', 'code'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
            [['code', 'days', 'months'], 'unique', 'targetAttribute' => ['code', 'days', 'months']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'days' => 'Days',
            'months' => 'Months',
            'is_refundable' => 'Is Refundable',
            'amount' => 'Amount',
            'amount_tax' => 'Amount Tax',
            'mrp' => 'Mrp',
            'mrp_tax' => 'Mrp Tax',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperatorStaticipAssocs() {
        return $this->hasMany(OperatorStaticipAssoc::className(), ['staticip_policy_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return StaticipPolicyQuery the active query used by this AR class.
     */
    public static function find() {
        return new StaticipPolicyQuery(get_called_class());
    }

}
