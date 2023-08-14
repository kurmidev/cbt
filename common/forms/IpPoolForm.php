<?php

namespace common\forms;

use common\models\IpPoolMaster;
use common\models\IpPoolList;
use common\ebl\Constants as C;
use common\component\Utils as U;

class IpPoolForm extends \yii\base\Model {

    public $ip_address;
    public $name;
    public $type;
    public $status;
    public $plugin_id;
    public $id;

    public function scenarios() {
        return [
            IpPoolMaster::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            IpPoolMaster::SCENARIO_CREATE => ['name', 'ip_address', 'type', 'status', 'plugin_id'],
            IpPoolMaster::SCENARIO_CONSOLE => ['name', 'ip_address', 'type', 'status', 'plugin_id'],
            IpPoolMaster::SCENARIO_UPDATE => ['id', 'name', 'ip_address', 'type', 'status', 'plugin_id'],
        ];
    }

    public function rules(): array {
        return [
            [["name", "ip_address", "type", "status", 'plugin_id'], "required"],
            [["type", "status", 'plugin_id'], "integer"],
            [["name"], "string"],
            [["ip_address"], "ip", "subnet" => true],
            ['plugin_id', 'exist', 'targetClass' => \common\models\PluginsMaster::class, 'targetAttribute' => ["plugin_id" => "id"], "filter" => ['plugin_type' => C::PLUGIN_TYPE_NAS]],
            ['ip_address', 'unique', 'targetClass' => IpPoolMaster::class, 'targetAttribute' => ["ip_address" => "ipaddress"]],
        ];
    }
    
    public function beforeValidate() {
        if(!empty($this->id)){
            $m = IpPoolList::find()->where(['id'=> $this->id,'']);
        }
        return parent::beforeValidate();
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
        $model = new IpPoolMaster(['scenario' => IpPoolMaster::SCENARIO_CREATE]);
        $model->name = $this->name;
        $model->ipaddress = $this->ip_address;
        $model->type = $this->type;
        $model->plugin_id = $this->plugin_id;
        $model->status = $this->status;
        if ($model->validate() && $model->save()) {
            $this->saveItems($model->id);
            return true;
        }else{
            print_r($model->errors);
            exit;
        }
        return false;
    }

    public function update() {
        $model = PluginsMaster::findOne(['id' => $this->id]);
        if ($model instanceof PluginsMaster) {
            $model->scenario = PluginsMaster::SCENARIO_UPDATE;
            $model->status = $this->status;
            if ($model->validate() && $model->save()) {
                $this->saveItems($model->id);
                return true;
            }
        }
        return false;
    }

    public function saveItems($id) {
        if ($this->type == C::POOL_STATIC) {
            $ipaddress = U::ipnNetmaskRange($this->ip_address);
            foreach ($ipaddress as $ipaddres) {
                $model = IpPoolList::findOne(['pool_id' => $id, 'ipaddress' => $this->ip_address, 'plugin_id' => $this->plugin_id]);
                if (!$model instanceof IpPoolList) {
                    $model = new IpPoolList(['scenario' => IpPoolList::SCENARIO_CREATE]);
                    $model->pool_id = $id;
                    $model->plugin_id = $this->plugin_id;
                }
                $model->ipaddress = $ipaddres;
                $model->name = $this->name;
                $model->status = !empty($model->status) ? $model->status : C::IP_FREE;
                if ($model->validate() && $model->save()) {
                    
                }
            }
        }
    }

}
