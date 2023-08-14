<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * This is the model class for table "ip_pool_list".
 *
 * @property int $id
 * @property int $pool_id
 * @property string $name
 * @property string $ipaddress
 * @property int $plugin_id
 * @property int|null $operator_id
 * @property int|null $account_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property float|null $per_day_amount
 * @property float|null $amount
 * @property float|null $tax
 * @property float|null $per_day_mrp
 * @property float|null $mrp
 * @property float|null $mrp_tax
 * @property string|null $assigned_on
 * @property int|null $assigned_by
 * @property int $status
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property IpPoolMaster $pool
 */
class IpPoolList extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ip_pool_list';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'pool_id', 'name', 'ipaddress', 'plugin_id', 'status'],
            self::SCENARIO_CONSOLE => ['id', 'pool_id', 'name', 'ipaddresss', 'plugin_id', 'assigned_id', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_UPDATE => ['id', 'pool_id', 'name', 'ipaddress', 'plugin_id', 'operator_id', 'account_id', 'start_date', 'end_date', 'per_day_amount', 'amount', 'tax', 'per_day_mrp', 'mrp', 'mrp_tax', 'assigned_on', 'assigned_by', 'status'],
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
            [['pool_id', 'name', 'ipaddress', 'plugin_id', 'status'], 'required'],
            [['pool_id', 'plugin_id', 'operator_id', 'account_id', 'assigned_by', 'status', 'added_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'assigned_on', 'added_on', 'updated_on'], 'safe'],
            [['per_day_amount', 'amount', 'tax', 'per_day_mrp', 'mrp', 'mrp_tax'], 'number'],
            [['name', 'ipaddress'], 'string', 'max' => 255],
            ['plugin_id', 'exist', 'targetClass' => \common\models\PluginsMaster::class, 'targetAttribute' => ["plugin_id" => "id"], "filter" => ['plugin_type' => C::PLUGIN_TYPE_NAS]],
            [['pool_id'], 'exist', 'skipOnError' => true, 'targetClass' => IpPoolMaster::className(), 'targetAttribute' => ['pool_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlugin() {
        return $this->hasOne(PluginMasterSearch::className(), ['id' => 'plugin_id']);
    }

    /**
     * Gets query for [[Pool]].
     *
     * @return \yii\db\ActiveQuery|IpPoolMasterQuery
     */
    public function getPool() {
        return $this->hasOne(IpPoolMaster::className(), ['id' => 'pool_id']);
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
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'pool_id' => 'Pool',
            'name' => 'Name',
            'ipaddress' => 'Ipaddress',
            'plugin_id' => 'Plugin ID',
            'operator_id' => 'Operator ID',
            'account_id' => 'Account ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'per_day_amount' => 'Per Day Amount',
            'amount' => 'Amount',
            'tax' => 'Tax',
            'per_day_mrp' => 'Per Day Mrp',
            'mrp' => 'Mrp',
            'mrp_tax' => 'Mrp Tax',
            'assigned_on' => 'Assigned On',
            'assigned_by' => 'Assigned By',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     */
    public function extraFields() {
        $fields = parent::extraFields();

        return $fields;
    }

    /**
     * {@inheritdoc}
     * @return IpPoolListQuery the active query used by this AR class.
     */
    public static function find() {
        return new IpPoolListQuery(get_called_class());
    }

}
