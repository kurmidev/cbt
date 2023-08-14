<?php

namespace common\models;

use Yii;

/**
 * Model designation property.
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $parent_id
 * @property integer $status
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 */
class Designation extends \common\models\BaseModel {

    public $menu;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'designation';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'code', 'parent_id', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by', 'menu'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'code', 'parent_id', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by', 'menu'],
            self::SCENARIO_UPDATE => ['id', 'parent_id', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by', 'menu'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if ($this->scenario == self::SCENARIO_CREATE) {
            $this->code = empty($this->code) ? $this->generateCode(\common\ebl\Constants::PREFIX_DESIG) : $this->code;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) {
        if (!empty($this->menu)) {
            $this->saveMenuData();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeValidate() {
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'parent_id'], 'required'],
            [['parent_id', 'status', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
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

    public function attributes() {
        return [
            'id',
            'name',
            'code',
            'parent_id',
            'status',
            'added_on',
            'updated_on',
            'added_by',
            'updated_by'
        ];
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

    public function getParent() {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     * @return DesignationQuery the active query used by this AR class.
     */
    public static function find() {
        return new DesignationQuery(get_called_class());
    }

    public function saveMenuData() {
        if (!empty($this->menu)) {
            $menu = array_keys($this->menu);
            \common\ebl\AuthUser::addDesignationAuthRule($this->code, $menu);
        }
    }

}
