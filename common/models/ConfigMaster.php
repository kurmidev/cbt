<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "config_master".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $type
 * @property string|null $config
 * @property int|null $status
 * @property string|null $added_on
 * @property int|null $added_by
 * @property string|null $modified_on
 * @property int|null $modified_by
 */
class ConfigMaster extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'config_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['config', 'name', 'type'], 'required'],
            [['config', 'added_on', 'modified_on'], 'safe'],
            [['status', 'added_by', 'modified_by'], 'integer'],
            [['name', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'config' => 'Config',
            'status' => 'Status',
            'added_on' => 'Added On',
            'added_by' => 'Added By',
            'modified_on' => 'Modified On',
            'modified_by' => 'Modified By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ConfigMasterQuery the active query used by this AR class.
     */
    public static function find() {
        return new ConfigMasterQuery(get_called_class());
    }

    public static function getActiveConfig() {
        return \Yii::$app->cache->getOrSet("active_config", function () {
                    return self::getConfig();
                });
    }

    public static function getAllConfig() {
        return \Yii::$app->cache->getOrSet("all_config", function () {
                    return self::getConfig(0);
                });
    }

    public static function getConfig($isActive = 1) {
        $query = ConfigMaster::find();
        if ($isActive) {
            $query->active();
        }
        $d = $query->asArray()->all();
        if (!empty($d)) {
            return \yii\helpers\ArrayHelper::index($d, 'id', 'type');
        }

        return [];
    }

}
