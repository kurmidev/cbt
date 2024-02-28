<?php

namespace common\forms;

use common\models\BaseTraits;
use yii\base\DynamicModel;
use yii\base\Model;
use common\ebl\Constants as C;
use common\models\Services;
use common\models\ServicesMapping;
use common\models\ServicesSettings;
use yii\db\Query;

class ServiceForm extends Model
{

    use BaseTraits;

    public $id;
    public $name;
    public $code;
    public $service_type;
    public $type;
    public $broadcaster_id;
    public $language_id;
    public $genre_id;
    public $is_alacarte;
    public $is_fta;
    public $rate;
    public $description;
    public $meta_data;

    public $cas_code_mapping;

    public $service_mapping;
    public $status;

    public function rules()
    {
        $casCodemapping = (new DynamicModel(['plugin_id', 'other_codes', 'plugin_code']))
            ->addRule(['plugin_id', 'plugin_code'], 'required')
            ->addRule(['other_codes', 'plugin_code'], 'string')
            ->addRule(["plugin_code","plugin_id"], "unique", ['targetClass' => ServicesSettings::class, 'targetAttribute' => ['plugin_code' => 'plugin_code','plugin_id'=>'plugin_id']])
            ->addRule(['plugin_id'], 'integer');

        return [
            [["name", "service_type", "is_alacarte", "is_fta", "rate", "status","type"], "required"],
            [["name", "description"], "string"],
            [["service_type", "broadcaster_id", "language_id", "genre_id", "is_alacarte", "is_fta", "status"], "integer"],
            [["rate"], "number"],
            [["broadcaster_id", "language_id", "genre_id", "is_alacarte", "is_fta"], 'required', 'when' => function () {
                return in_array($this->service_type, [C::SERVICE_TYPE_CHANNEL, C::SERVICE_TYPE_OTT]);
            }],
            [["is_fta"], 'required', 'when' => function () {
                return in_array($this->service_type, [C::SERVICE_TYPE_PACKAGE,C::SERVICE_TYPE_CHANNEL]);
            }],
            [["broadcaster_id", "is_fta"], 'required', 'when' => function () {
                return in_array($this->service_type, [C::SERVICE_TYPE_BROADCASTER]);
            }],
            [["service_mapping"], 'required', 'when' => function () {
                return !in_array($this->service_type, [C::SERVICE_TYPE_CHANNEL]);
            }],
            [['cas_code_mapping'], 'ValidateMulti', 'params' => ['isMulti' => TRUE, 'ValidationModel' => $casCodemapping, 'allowEmpty' => FALSE]],
        ];
    }

    public function scenarios()
    {
        return [
            Services::SCENARIO_DEFAULT => ["*"],
            Services::SCENARIO_CREATE => ["name", "rate", "service_type","type", "broadcaster_id", "language_id", "genre_id", "is_alacarte", "is_fta", "status", "cas_code_mapping", "service_mapping"],
            Services::SCENARIO_CREATE => ["name", "rate", "service_type","type", "broadcaster_id", "language_id", "genre_id", "is_alacarte", "is_fta", "status", "cas_code_mapping", "service_mapping"],
        ];
    }

    public function save()
    {
        if (!$this->hasErrors()) {
            if (empty($this->id)) {
                return $this->create();
            } else {
                return $this->update($this->id);
            }
        }
        return false;
    }

    public function create()
    {
        $model  = new Services(['scenario' => Services::SCENARIO_CREATE]);
        $model->name = $this->name;
        $model->service_type = $this->service_type;
        $model->type = $this->type;
        $model->description = $this->description;
        $model->status = $this->status;
        $model->is_alacarte = $this->is_alacarte;
        $model->broadcaster_id = $this->broadcaster_id;
        $model->language_id = $this->language_id;
        $model->genre_id = $this->genre_id;
        $model->is_fta = $this->is_fta;
        $model->rate = $this->rate;
        if ($model->validate() && $model->save()) {
            $this->casCodeMapping($model->id);
            $this->serviceMapping($model->id);
            return true;
        } else {
            $this->addErrors($model->getErrors());
            print_r($model->errors);
        }
        return false;
    }

    public function update($id)
    {
        $model  = Services::findOne(["id" => $id]);
        if ($model instanceof Services) {
            $model->name = $this->name;
            $model->service_type = $this->service_type;
            $model->description = $this->description;
            $model->status = $this->status;
            $model->is_alacarte = $this->is_alacarte;
            $model->broadcaster_id = $this->broadcaster_id;
            $model->language_id = $this->language_id;
            $model->genre_id = $this->genre_id;
            $model->is_fta = $this->is_fta;
            $model->rate = $this->rate;
            if ($model->validate() && $model->save()) {
                $this->casCodeMapping($model->id);
                $this->serviceMapping($model->id);
                return true;
            } else {
                $this->addErrors($model->getErrors());
            }
        }
        return false;
    }

    public function serviceMapping($service_id)
    {
        $del_id =  [];
        if (!empty($this->service_mapping)) {
            foreach ($this->service_mapping as $mapping) {
                $model = ServicesMapping::find()->where(['child_id' => $mapping, 'parent_id' => $service_id])->one();
                if (!$model instanceof ServicesMapping) {
                    $model = new ServicesMapping(['scenario' => ServicesMapping::SCENARIO_CREATE]);
                    $model->service_id = $model->parent_id = $service_id;
                    $model->child_id =  $mapping;
                    if ($model->validate() && $model->save()) {
                        $del_id[] = $model->id;
                    }
                } else {
                    $del_id[] = $model->id;
                }
            }
        }
        if (!empty($del_id)) {
            $query  = (new Query())->where(['service_id' => $service_id])->where(['not', ['id' => $del_id]]);
            ServicesMapping::deleteAll($query->where);
        }
    }

    public function casCodeMapping($service_id)
    {
        $del_id =  [];
        if (!empty($this->cas_code_mapping)) {
            foreach ($this->cas_code_mapping as $cas_map) {
                $model = ServicesSettings::find()->where(['service_id' => $service_id, 'plugin_id' => $cas_map['plugin_id'], 'plugin_code' => $cas_map['plugin_code']])->one();
                if ($model instanceof ServicesSettings) {
                    $model->scenario = ServicesSettings::SCENARIO_UPDATE;
                    $model->other_codes  = $cas_map['other_codes'];
                    if ($model->validate() && $model->save()) {
                        $del_id[] = $model->id;
                    }
                } else {
                    $model = new ServicesSettings(['scenario' => ServicesSettings::SCENARIO_CREATE]);
                    $model->service_id = $service_id;
                    $model->plugin_id = $cas_map['plugin_id'];
                    $model->plugin_code = $cas_map['plugin_code'];
                    $model->other_codes = $cas_map['other_codes'];
                    if ($model->validate() && $model->save()) {
                        $del_id[] = $model->id;
                    }
                }
            }

            if (!empty($del_id)) {
                $query  = (new Query())->where(['service_id' => $service_id])->where(['not', ['id' => $del_id]]);
                ServicesSettings::deleteAll($query->where);
            }
        }
    }
}
