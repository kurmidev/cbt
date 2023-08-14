<?php

namespace common\models;

use Yii;

/**
 * Model reason property.
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property array $reason_for
 * @property integer $status
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 */
class Reason extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'reason';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'code', 'description', 'reason_for', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'code', 'description', 'reason_for', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_UPDATE => ['id', 'name', 'code', 'description', 'reason_for', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {

        if ($this->scenario == self::SCENARIO_CREATE) {
            $this->code = empty($this->code) ? $this->generateCode(\common\ebl\Constants::PREFIX_REASON) : $this->code;
        }

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
                [['name', 'status'], 'required'],
                [['status', 'added_by', 'updated_by'], 'integer'],
                [['added_on', 'updated_on'], 'safe'],
                [['name', 'code', 'description'], 'string', 'max' => 255],
                [['name'], 'unique'],
                //[['code'], 'unique'],
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
            'description',
            'reason_for',
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
     * @return ReasonMaster the active query used by this AR class.
     */
    /* public static function find(){
      return new ReasonMaster(get_called_class())->applycache();
      }
     */
}
