<?php

namespace common\models;

use Yii;

/**
 * Model nas property.
 *
 * @property integer $id
 * @property string $ip_address
 * @property string $name
 * @property string $code
 * @property integer $ports
 * @property string $type
 * @property string $secret
 * @property string $description
 * @property array $meta_data
 * @property integer $status
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 */
class Nas extends \common\models\BaseModel {

    public $ippool;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'nas';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'ip_address', 'name', 'code', 'ports', 'type', 'secret', 'description', 'meta_data', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by', 'username', 'password'],
            self::SCENARIO_CONSOLE => ['id', 'ip_address', 'name', 'code', 'ports', 'type', 'secret', 'description', 'meta_data', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by', 'username', 'password'],
            self::SCENARIO_UPDATE => ['id', 'ip_address', 'name', 'code', 'ports', 'type', 'secret', 'description', 'meta_data', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by', 'username', 'password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        $prefix = \common\ebl\Constants::PREFIX_NAS;
        $this->code = empty($this->code) ? $this->generateCode($prefix) : $this->code;
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
            [['name', 'secret', 'username', 'password', 'status', 'ip_address'], 'required'],
            [['ports', 'status', 'added_by', 'updated_by'], 'integer'],
            [['meta_data'], 'string'],
            [['added_on', 'updated_on'], 'safe'],
            [['ip_address', 'name', 'code', 'type', 'secret', 'description'], 'string', 'max' => 255],
            [['ip_address'], 'unique'],
                //[['code'], 'unique'],
        ];
    }

    public function getAttrs() {
        return [
            //'policy_rules' => 'policyRules',
            'ippool' => 'ipPoolMaster',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields() {
        $fields = [
            'id',
            'ip_address',
            'name',
            'code',
            'ports',
            'type',
            'secret',
            'description',
            'meta_data',
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
     * @return NasQuery the active query used by this AR class.
     */
    public static function find() {
        return (new NasQuery(get_called_class()));
    }

    public function getIpPoolMaster() {
        return $this->hasMany(IpPoolMaster::class, ['nas_id' => 'id']);
    }

}
