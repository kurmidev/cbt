<?php

namespace common\forms;

use common\ebl\Constants as C;
use common\component\Utils as U;
use common\models\PluginsMaster;
use common\models\PluginsItems;

class NasForm extends \yii\base\Model {

    use \common\models\BaseTraits;

    public $id;
    public $name;
    public $plugin_url;
    public $description;
    public $ports;
    public $type;
    public $secret;
    public $meta_data;
    public $status;
    public $username;
    public $password;

    public function scenarios() {
        return [
            PluginsMaster::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            PluginsMaster::SCENARIO_CREATE => ['id', 'plugin_url', 'name', 'ports', 'type', 'secret', 'description', 'meta_data', 'status', 'username', 'password'],
            PluginsMaster::SCENARIO_CONSOLE => ['id', 'plugin_url', 'name', 'ports', 'type', 'secret', 'description', 'meta_data', 'status', 'username', 'password'],
            PluginsMaster::SCENARIO_UPDATE => ['id', 'plugin_url', 'name', 'ports', 'type', 'secret', 'description', 'meta_data', 'status', 'username', 'password'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['plugin_url', 'validateIpAddress'],
            [['plugin_url', 'name', 'type', 'secret', 'status', 'username', 'password'], 'required'],
            [['ports', 'description', 'meta_data'], 'safe'],
            [['plugin_url', 'name', 'secret', 'description'], 'string'],
        ];
    }

    public function validateIpAddress($attribute, $params, $validator) {
        $m = PluginsMaster::find()->andWhere(["plugin_url" => $this->plugin_url])
                        ->andFilterWhere(['not', ['id' => $this->id]])
                        ->andWhere(['plugin_type' => C::PLUGIN_TYPE_NAS])->count();
        if ($m > 1) {
            $this->addError("plugin_url", "Ip Address {$this->plugin_url} already registered.");
            return false;
        }

        return true;
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
        $model->plugin_type = C::PLUGIN_TYPE_NAS;
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
            $model->plugin_type = C::PLUGIN_TYPE_NAS;
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
        $items = \yii\helpers\ArrayHelper::merge(
                        \yii\helpers\ArrayHelper::map($this->meta_data, "name", "value"),
                        [
                            "username" => $this->username,
                            "password" => $this->password,
                            "ports" => "1" . $this->ports,
                            "type" => $this->type,
                            "secret" => $this->secret,
        ]);

        PluginsItems::deleteAll(['plugin_id' => $pgid]);
        foreach ($items as $name => $value) {
            $model = new PluginsItems(['scenario' => PluginsItems::SCENARIO_CREATE]);
            $model->plugin_id = $pgid;
            $model->name = $name;
            $model->value = $value;
            if ($model->validate() && $model->save()) {
                
            } else {
                print_r($model->errors);
                exit("sss");
            }
        }
    }

}
