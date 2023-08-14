<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plugins_items".
 *
 * @property int $id
 * @property int $plugin_id
 * @property string $name
 * @property string $value
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property PluginsMaster $plugin
 */
class PluginsItems extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'plugins_items';
    }

    public function scenarios() {
        return [
            self::SCENARIO_CREATE => ['id', 'name', 'plugin_id', 'value'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'plugin_id', 'value'],
            self::SCENARIO_UPDATE => ['id', 'name', 'plugin_id', 'value'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['plugin_id', 'name', 'value'], 'required'],
            [['plugin_id', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'value'], 'string', 'max' => 255],
            [['plugin_id'], 'exist', 'skipOnError' => true, 'targetClass' => PluginsMaster::className(), 'targetAttribute' => ['plugin_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'plugin_id' => 'Plugin ID',
            'name' => 'Name',
            'value' => 'Value',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Plugin]].
     *
     * @return \yii\db\ActiveQuery|PluginsMasterQuery
     */
    public function getPlugin() {
        return $this->hasOne(PluginsMaster::className(), ['id' => 'plugin_id']);
    }

    /**
     * {@inheritdoc}
     * @return PluginsItemsQuery the active query used by this AR class.
     */
    public static function find() {
        return new PluginsItemsQuery(get_called_class());
    }

}
