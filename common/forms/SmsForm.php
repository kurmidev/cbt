<?php

namespace common\forms;

use common\models\PluginsMaster;
use common\ebl\Constants as C;

class SmsForm extends \yii\base\Model {

    public $id;
    public $name;
    public $plugin_url;
    public $description;
    public $status;

    public function scenarios() {
        return [
            PluginsMaster::SCENARIO_CREATE => ['id', 'name', 'plugin_url', 'description', 'status'],
            PluginsMaster::SCENARIO_CONSOLE => ['id', 'name', 'plugin_url', 'description', 'status'],
            PluginsMaster::SCENARIO_UPDATE => ['id', 'name', 'plugin_url', 'description', 'status'],
        ];
    }

    public function rules(): array {
        return [
            [["name", "plugin_url", "status"], "required"],
            [["name", "description", "plugin_url"], "string"],
            [["status"], "integer"]
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
        $model = new PluginsMaster(['scenario' => PluginsMaster::SCENARIO_CREATE]);
        $model->name = $this->name;
        $model->plugin_type = C::PLUGIN_TYPE_MOBILE_SMS;
        $model->plugin_url = $this->plugin_url;
        $model->meta_data = [];
        $model->description = $this->description;
        $model->status = $this->status;
        if ($model->validate() && $model->save()) {
            return true;
        }
        return false;
    }

    public function update() {
        $model = PluginsMaster::findOne(['id' => $this->id]);
        if ($model instanceof PluginsMaster) {
            $model->scenario = PluginsMaster::SCENARIO_UPDATE;
            $model->name = $this->name;
            $model->plugin_type = C::PLUGIN_TYPE_MOBILE_SMS;
            $model->plugin_url = $this->plugin_url;
            $model->meta_data = [];
            $model->description = $this->description;
            $model->status = $this->status;
            if ($model->validate() && $model->save()) {
                return true;
            }
        }
        return false;
    }

}
