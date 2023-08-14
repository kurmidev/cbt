<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * Model ip_pool_master property.
 *
 * @property integer $id
 * @property string $name
 * @property string $ipaddress
 * @property integer $type
 * @property integer $plugin_id
 * @property integer $status
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 *
 * @property IpPoolList[] $ipPoolLists
 * @property Nas $nas
 */
class IpPoolMaster extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'ip_pool_master';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'ipaddress', 'type', 'plugin_id', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'ipaddress', 'type', 'plugin_id', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_UPDATE => ['id', 'name', 'ipaddress', 'type', 'plugin_id', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
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
            [['name', 'ipaddress', 'type', 'plugin_id', 'status'], 'required'],
            [['type', 'status'], 'string'],
            [['plugin_id', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'ipaddress'], 'string', 'max' => 255],
            ['plugin_id', 'exist', 'targetClass' => \common\models\PluginsMaster::class, 'targetAttribute' => ["plugin_id" => "id"], "filter" => ['plugin_type' => C::PLUGIN_TYPE_NAS]],
            ['ipaddress', 'unique', 'targetClass' => IpPoolMaster::class, 'targetAttribute' => ["ipaddress" => "ipaddress"]],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIpPoolLists() {
        return $this->hasMany(IpPoolList::className(), ['pool_id' => 'id', 'plugin_id' => 'plugin_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlugin() {
        return $this->hasOne(PluginsMaster::className(), ['id' => 'plugin_id']);
    }

    /**
     * with
     * @return type
     */
    function defaultWith() {
        return ['plugin'];
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
            'ipaddress',
            'type',
            'plugin_id',
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
     * @return IpPoolMasterQuery the active query used by this AR class.
     */
    public static function find() {
        return new IpPoolMasterQuery(get_called_class());
    }

}
