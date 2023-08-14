<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plugins_master".
 *
 * @property int $id
 * @property string $name
 * @property int $plugin_type
 * @property string $plugin_url
 * @property string|null $meta_data
 * @property string|null $description
 * @property int $status
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property PluginsItems[] $pluginsItems
 */
class PluginsMaster extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'plugins_master';
    }

    public function scenarios() {
        return [
            self::SCENARIO_CREATE => ['id', 'name', 'plugin_url', 'plugin_type', 'meta_data', 'description', 'status'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'plugin_url', 'plugin_type', 'meta_data', 'description', 'status'],
            self::SCENARIO_UPDATE => ['id', 'name', 'plugin_url', 'plugin_type', 'meta_data', 'description', 'status'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'plugin_type', 'plugin_url'], 'required'],
            [['plugin_type', 'status', 'added_by', 'updated_by'], 'integer'],
            [['meta_data', 'added_on', 'updated_on'], 'safe'],
            [['name', 'plugin_url', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'plugin_type' => 'Plugin Type',
            'plugin_url' => 'Plugin Url',
            'meta_data' => 'Meta Data',
            'description' => 'Description',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[PluginsItems]].
     *
     * @return \yii\db\ActiveQuery|PluginsItemsQuery
     */
    public function getPluginsItems() {
        return $this->hasMany(PluginsItems::className(), ['plugin_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PluginsMasterQuery the active query used by this AR class.
     */
    public static function find() {
        return new PluginsMasterQuery(get_called_class());
    }

}
