<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reason".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property array $reason_for
 * @property int $status
 * @property string $added_on
 * @property string $updated_on
 * @property int $added_by
 * @property int $updated_by
 */
class Reason extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'reason';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'reason_for'], 'required'],
            [['added_on', 'updated_on'], 'safe'],
            [['status', 'added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'description'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique'],
        ];
    }

    public function fields() {
        $fields = [
            'name',
            'code',
            'reason_for',
            'status',
            'description',
            'added_on',
            'added_by',
            'updated_on',
            'updated_by'
        ];
        return \yii\helpers\ArrayHelper::merge($fields, parent::fields());
    }

    public function extraFields() {
        $fields = [];
        return \yii\helpers\ArrayHelper::merge($fields, parent::fields());
    }

    public function beforeSave($insert) {
        if ($this->scenario == self::SCENARIO_CREATE) {
            $this->code = empty($this->code) ? $this->generateCode(\common\ebl\Constants::PREFIX_REASON) : $this->code;
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
            'reason_for' => 'Reason For',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ReasonQuery the active query used by this AR class.
     */
    public static function find() {
        return new ReasonQuery(get_called_class());
    }

}
