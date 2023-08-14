<?php

namespace common\forms;

use common\models\Nas;
use common\models\IpPoolMaster;
use common\models\IpPoolList;
use common\ebl\Constants as C;
use common\component\Utils as U;
use yii\base\DynamicModel;

class NasForm extends \yii\base\Model {

    use \common\models\BaseTraits;

    public $id;
    public $ip_address;
    public $name;
    public $ports;
    public $type;
    public $secret;
    public $description;
    public $meta_data;
    public $status;
    public $ippool;
    public $username;
    public $password;

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            Nas::SCENARIO_CREATE => ['id', 'ip_address', 'name', 'ports', 'type', 'secret', 'description', 'meta_data', 'status', 'ippool', 'username', 'password'],
            Nas::SCENARIO_CONSOLE => ['id', 'ip_address', 'name', 'ports', 'type', 'secret', 'description', 'meta_data', 'status', 'ippool', 'username', 'password'],
            Nas::SCENARIO_UPDATE => ['id', 'ip_address', 'name', 'ports', 'type', 'secret', 'description', 'meta_data', 'status', 'ippool', 'username', 'password'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        $ippool = (new DynamicModel(['name', 'ipaddresss', 'type', 'status']))
                ->addRule(['name', 'ipaddresss', 'type', 'status'], 'required')
                ->addRule(['type'], 'in', ['range' => array_keys(C::$POOL_TYPES)]);

        return [
            [['ip_address', 'name', 'type', 'secret', 'status', 'ippool'], 'required'],
            [['username', 'password'], 'required', 'on' => Nas::SCENARIO_CREATE],
            [['ports', 'description', 'meta_data'], 'safe'],
            [['ip_address', 'name', 'secret', 'description'], 'string'],
            [['ip_address'], 'unique', 'targetClass' => Nas::class, "targetAttribute" => ["ip_address" => "ip_address"]],
            [['ippool'], 'ValidateMulti', 'params' => ['isMulti' => true,
                    'ValidationModel' => $ippool,
                    'allowEmpty' => true]]
        ];
    }

    public function save($runValidation = true, $attributeNames = null) {
        if (!$this->hasErrors()) {
            if ($this->id) {
                return $this->update();
            } else {
                return $this->create();
            }
        }
        return false;
    }

    public function create() {
        $model = new Nas(['scenario' => Nas::SCENARIO_CREATE]);
        $model->load($this->attributes, '');
        if ($model->validate() && $model->save()) {
            $this->id = $model->id;
            $this->addpools($this->id);
            return $model;
        } else {
            $this->addErrors($model->errors);
        }
        return FALSE;
    }

    public function update() {
        $model = Nas::findOne($this->id);
        if ($model instanceof Nas) {
            $model->scenario = Nas::SCENARIO_UPDATE;
            $model->load($this->attributes, '');
            if ($model->validate() && $model->save()) {
                $this->id = $model->id;
                $this->addpools($this->id);
                return $model;
            } else {
                $this->addErrors($model->errors);
            }
        }
        return false;
    }

    public function addpools($id) {
        if (!empty($this->ippool)) {
            foreach ($this->ippool as $pools) {
                $model = IpPoolMaster::findOne(['ipaddresss' => $pools['ipaddresss'], 'nas_id' => $id]);
                if (!$model instanceof IpPoolMaster) {
                    $model = new IpPoolMaster(['scenario' => IpPoolMaster::SCENARIO_CREATE]);
                    $model->nas_id = $id;
                }
                $model->status = $pools['status'];
                $model->ipaddresss = $pools['ipaddresss'];
                $model->type = $pools['type'];
                $model->name = $pools['name'];
                if ($model->validate() && $model->save()) {
                    if ($model->type == C::POOL_STATIC) {
                        $this->addStaticPools($model);
                    }
                }
            }
        }
    }

    public function addStaticPools(IpPoolMaster $pool) {
        $ipaddress = U::ipnNetmaskRange($pool->ipaddresss);
        foreach ($ipaddress as $ipaddres) {
            $model = IpPoolList::findOne(['pool_id' => $pool->id, 'ipaddresss' => $pool->ipaddresss, 'nas_id' => $pool->nas_id]);
            if (!$model instanceof IpPoolList) {
                $model = new IpPoolList(['scenario' => IpPoolList::SCENARIO_CREATE]);
                $model->pool_id = $pool->id;
                $model->nas_id = $pool->nas_id;
            }
            $model->ipaddresss = $ipaddres;
            $model->name = $pool->name;
            $model->assigned_id = !empty($model->assigned_id) ? $model->assigned_id : NULL;
            $model->status = !empty($model->status) ? $model->status : C::IP_FREE;
            if ($model->validate()) {
                $model->save();
            } else {
                print_r($model->errors);
                exit("frvdc");
            }
        }
    }

}
