<?php

namespace common\models;

use Yii;

/**
 * Model period_master property.
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $days
 * @property integer $status
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 */
class PeriodMaster extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'period_master';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'code', 'days', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'code', 'days', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_UPDATE => ['id', 'name', 'code', 'days', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
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
        if ($insert) {
            $this->code = empty($this->code) ? $this->generateCode(\common\ebl\Constants::PREFIX_PERIOD) : $this->code;
            self::updateAll(['code' => $this->code], ['id' => $this->id]);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['days', 'status', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['days'], 'unique'],
            [['name', 'code'], 'string', 'max' => 255],
            [['name', 'days'], 'unique', 'targetAttribute' => ['name', 'days'], 'message' => 'The combination of Name and Days has already been taken.'],
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
            'days',
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

    /**
     * @inheritdoc
     * @return PeriodMasterQuery the active query used by this AR class.
     */
    public static function find() {
        return new PeriodMasterQuery(get_called_class());
    }

}
