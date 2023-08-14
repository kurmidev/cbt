<?php

namespace common\models;

use Yii;

/**
 * Model bank_master property.
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $address
 * @property string $branch
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 */
class BankMaster extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'bank_master';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'code', 'address', 'branch', 'added_on', 'updated_on', 'added_by', 'updated_by', 'status'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'code', 'address', 'branch', 'added_on', 'updated_on', 'added_by', 'updated_by', 'status'],
            self::SCENARIO_UPDATE => ['id', 'name', 'code', 'address', 'branch', 'added_on', 'updated_on', 'added_by', 'updated_by', 'status'],
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
            [['code', 'status'], 'required'],
            [['added_on', 'updated_on'], 'safe'],
            [['added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'address', 'branch'], 'string', 'max' => 255],
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
            'address',
            'branch',
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
     * @return BankMasterQuery the active query used by this AR class.
     */
    /* public static function find(){
      return new BankMasterQuery(get_called_class())->applycache();
      }
     */
}
