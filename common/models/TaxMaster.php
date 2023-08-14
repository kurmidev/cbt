<?php

namespace common\models;

use Yii;

/**
 * Model tax property.
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $type
 * @property string $value
 * @property array $applicable_on
 * @property integer $status
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 */
class TaxMaster extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tax';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'code', 'type', 'value', 'applicable_on', 'status'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'code', 'type', 'value', 'applicable_on', 'status'],
            self::SCENARIO_UPDATE => ['id', 'name', 'code', 'type', 'value', 'applicable_on', 'status'],
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
            [['name', 'value', 'code', 'applicable_on'], 'required'],
            [['type', 'status'], 'integer'],
            [['value'], 'number'],
            [['name', 'code'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique'],
        ];
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
            'name',
            'code',
            'type',
            'value',
            'applicable_on',
            'status',
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

    public function getApplicableLabel() {
        $res = [];
        if (!empty($this->applicable_on)) {
            foreach ($this->applicable_on as $a) {
                if (!empty(\common\ebl\Constants::LABEL_TAX_APPLICABLE_ON[$a])) {
                    $res [] = \common\ebl\Constants::LABEL_TAX_APPLICABLE_ON[$a];
                }
            }
        }
        return !empty($res) ? implode(", ", $res) : "";
    }

    public function getFormula() {
        if ($this->type == \common\ebl\Constants::TAX_TYPE_AMOUNT) {
            return "$this->value";
        } else {
            return "amount * ($this->value/100)";
        }
    }

    /**
     * @inheritdoc
     * @return TaxMasterQuery the active query used by this AR class.
     */
    /* public static function find(){
      return new TaxMasterQuery(get_called_class())->applycache();
      }
     */
}
