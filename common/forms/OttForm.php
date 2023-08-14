<?php

namespace common\forms;

use common\models\PluginsMaster;
use common\models\PluginsItems;
use common\ebl\Constants as C;

class OttForm extends \yii\base\Model {

    public $id;
    public $name;
    public $plugin_url;
    public $description;
    public $status;
    public $meta_data;

    public function scenarios() {
        return [
            PluginsMaster::SCENARIO_CREATE => ['id', 'name', 'plugin_url', 'description', 'status', 'meta_data'],
            PluginsMaster::SCENARIO_CONSOLE => ['id', 'name', 'plugin_url', 'description', 'status', 'meta_data'],
            PluginsMaster::SCENARIO_UPDATE => ['id', 'name', 'plugin_url', 'description', 'status', 'meta_data'],
        ];
    }

    public function rules(): array {
        return [
            [["name", "plugin_url", "status"], "required"],
            [["name", "description", "plugin_url"], "string"],
            [["status"], "integer"],
            [['meta_data'], 'safe']
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
        $model->plugin_type = C::PLUGIN_TYPE_OTT;
        $model->plugin_url = $this->plugin_url;
        $model->meta_data = $this->meta_data;
        $model->description = $this->description;
        $model->status = $this->status;
        if ($model->validate() && $model->save()) {
            $this->saveItems($model->id);
            return true;
        }
        return false;
    }

    public function update() {
        $model = PluginsMaster::findOne(['id' => $this->id]);
        if ($model instanceof PluginsMaster) {
            $model->scenario = PluginsMaster::SCENARIO_UPDATE;
            $model->name = $this->name;
            $model->plugin_type = C::PLUGIN_TYPE_OTT;
            $model->plugin_url = $this->plugin_url;
            $model->meta_data = $this->meta_data;
            $model->description = $this->description;
            $model->status = $this->status;
            if ($model->validate() && $model->save()) {
                $this->saveItems($model->id);
                return true;
            }
        }
        return false;
    }

    public function saveItems($pgid) {
        $items = \yii\helpers\ArrayHelper::map($this->meta_data, "name", "value");
        if (!empty($items)) {
            PluginsItems::deleteAll(['plugin_id' => $pgid]);
            foreach ($items as $name => $value) {
                $model = new PluginsItems(['scenario' => PluginsItems::SCENARIO_CREATE]);
                $model->plugin_id = $pgid;
                $model->name = $name;
                $model->value = $value;
                if ($model->validate() && $model->save()) {
                    
                }
            }
        }
    }

}
