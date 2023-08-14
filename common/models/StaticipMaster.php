<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * This is the model class for table "staticip_master".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class StaticipMaster extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'staticip_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'status','days'], 'required'],
            [['added_on', 'updated_on'], 'safe'],
            [['added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'description'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique'],
        ];
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['name', 'code', 'status', 'description','days'],
            self::SCENARIO_CONSOLE => ['name', 'code', 'status', 'description','days'],
            self::SCENARIO_UPDATE => ['name', 'code', 'status', 'description','days'],
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
            'status' => 'Status',
            'days' => 'Days',
            'description' => 'Description',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    public function beforeSave($insert) {
        $prefix = \common\ebl\Constants::PREFIX_STATIC;
        $this->code = empty($this->code) ? $this->generateCode($prefix) : $this->code;
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     * @return StaticipMasterQuery the active query used by this AR class.
     */
    public static function find() {
        return new StaticipMasterQuery(get_called_class());
    }

    public function getRates() {
        return $this->hasMany(RateMaster::class, ['assoc_id' => 'id'])->andOnCondition(['type' => C::RATE_TYPE_STATICIP]);
    }

    public function getAttrs() {
        return [
            'rates' => 'rates',
        ];
    }

}
