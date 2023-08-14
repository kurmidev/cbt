<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "router_master".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int|null $status
 * @property string|null $nas_type
 * @property string|null $setting
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class RouterMaster extends \common\models\BaseModel {

    public $attrbs;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'router_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'code'], 'required'],
            [['status', 'added_by', 'updated_by'], 'integer'],
            [['setting', 'added_on', 'updated_on', 'attrbs'], 'safe'],
            [['name', 'code', 'nas_type'], 'string', 'max' => 255],
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
            'nas_type' => 'Nas Type',
            'setting' => 'Setting',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return RouterMasterQuery the active query used by this AR class.
     */
    public static function find() {
        return new RouterMasterQuery(get_called_class());
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if (!empty($this->attrbs)) {
            RouterAttributes::deleteAll(['router_id' => $this->id]);
            foreach ($this->attrbs as $key => $val) {
                $model = new RouterAttributes(['scenario' => RouterAttributes::SCENARIO_CREATE]);
                $model->router_id = $this->id;
                $model->name = $val['name'];
                $model->op = $val['op'];
                $model->group = $val['group'];
                if ($model->validate() && $model->save()) {
                    //saved successfully
                }
            }
        }
    }

}
