<?php

namespace common\models;

use Yii;
use common\ebl\Constants;

/**
 * Model comp_cat property.
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $parent_id
 * @property string $description
 * @property integer $status
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 */
class CompCat extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'comp_cat';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'code', 'parent_id', 'description', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'code', 'parent_id', 'description', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_UPDATE => ['id', 'name', 'code', 'parent_id', 'description', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
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
            [['name', 'code'], 'required'],
            [['parent_id', 'status', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'description'], 'string', 'max' => 255],
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
            'parent_id',
            'description',
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
        $fields['parent_lbl'] = function () {
            return !empty($this->parent) ? $this->parent->name : NULL;
        };
        return $fields;
    }

    public function getParent() {
        return $this->hasOne(CompCat::class, ['id' => 'parent_id']);
    }

    public function beforeValidate() {
        if ($this->scenario == self::SCENARIO_CREATE) {
            $prefix = $this->parent_id > 0 ? Constants::PREFIX_SUBCOMP : Constants::PREFIX_COMP;
            $this->code = empty($this->code) ? $this->generateCode($prefix) : $this->code;
        }
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     * @return CompCatQuery the active query used by this AR class.
     */
    public static function find() {
        return (new CompCatQuery(get_called_class()));
    }
   

}
