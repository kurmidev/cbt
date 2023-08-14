<?php

namespace common\models;

use Yii;

/**
 * Model configuration property.
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property integer $config_for
 * @property string $attribute
 * @property string $op
 * @property string $value
 * @property integer $status
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 */
class Configuration extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'configuration';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'type', 'config_for', 'attribute', 'op', 'value', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'type', 'config_for', 'attribute', 'op', 'value', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_UPDATE => ['id', 'name', 'type', 'config_for', 'attribute', 'op', 'value', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
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
            [['name', 'type', 'attribute', 'value', 'status'], 'required'],
            [['config_for', 'added_by', 'updated_by'], 'integer'],
            [['status'], 'string'],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'type', 'attribute', 'op', 'value'], 'string', 'max' => 255],
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
            'type',
            'config_for',
            'attribute',
            'op',
            'value',
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
     * @return ConfigurationQuery the active query used by this AR class.
     */
    public static function find() {
        return new ConfigurationQuery(get_called_class());
    }

}
