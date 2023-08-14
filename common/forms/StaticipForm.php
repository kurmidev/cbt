<?php

namespace common\forms;

use common\models\StaticipMaster;
use common\ebl\Constants as C;
use common\models\RateMaster;
use common\component\Utils as U;

class StaticipForm extends \yii\base\Model {

    use \common\models\BaseTraits;

    public $id;
    public $name;
    public $description;
    public $status;
    public $days;
    public $rates;

    public function scenarios() {
        return [
            StaticipMaster::SCENARIO_CREATE => ['id', 'name', 'description', 'rates','days','status'],
            StaticipMaster::SCENARIO_CONSOLE => ['id', 'name', 'description', 'rates','days','status'],
            StaticipMaster::SCENARIO_UPDATE => ['id', 'name', 'description', 'rates','days','status'],
        ];
    }

    public function rules() {
        $dynamic_validate = (new \yii\base\DynamicModel(['name', 'amount', 'mrp']))
                ->addRule(['name', 'amount', 'mrp'], 'required')
                ->addRule(['amount', 'mrp'], "number");

        return [
            [['name', 'description', 'rates','days','status'], 'required'],
            [['name', 'description'], 'string'],
            [['days', 'status'], 'integer'],
            [['rates'], 'ValidateMulti', 'params' => ['isMulti' => TRUE, 'ValidationModel' => $dynamic_validate, 'allowEmpty' => FALSE]]
        ];
    }

    public function attributeLabels() {
        return (new StaticipMaster())->attributeLabels();
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
        $model = new StaticipMaster(['scenario' => StaticipMaster::SCENARIO_CREATE]);
        $model->load($this->attributes, '');
        if ($model->validate() && $model->save()) {
            $this->id = $model->id;
            $this->addRates($this->id);
            return TRUE;
        } else {
            print_r($model->errors);
            exit;
            $this->addErrors($model->errors);
        }
        return FALSE;
    }

    public function update() {
        $model = StaticipMaster::findOne($this->id);
        if ($model instanceof StaticipMaster) {
            $model->scenario = StaticipMaster::SCENARIO_UPDATE;
            $model->load($this->attributes, '');
            if ($model->validate() && $model->save()) {
                $this->id = $model->id;
                $this->addRates($this->id);
                return TRUE;
            } else {
                $this->addErrors($model->errors);
            }
        }
        return false;
    }

    public function addRates($planId) {
        $rateObj = RateMaster::find()->where(['assoc_id' => $planId, 'type' => C::RATE_TYPE_STATICIP])
                        ->indexBy('name')->all();
        $model = null;
        $delRate = [];
        foreach ($this->rates as $rate) {
            if (!empty($rateObj[$rate['name']])) {
                $model = $rateObj[$rate['name']];
                $model->scenario = RateMaster::SCENARIO_UPDATE;
            } else {
                $model = new RateMaster(['scenario' => RateMaster::SCENARIO_CREATE]);
                $model->name = $rate['name'];
                $model->assoc_id = $planId;
                $model->type = C::RATE_TYPE_STATICIP;
            }
            $model->amount = $rate['amount'];
            $model->mrp = $rate['mrp'];
            $model->tax = U::calculateTax($model->amount);
            $model->mrp_tax = U::calculateTax($model->mrp);

            if ($model->validate() && $model->save()) {
                $delRate[] = $model->id;
            }
        }
        if (!empty($delRate)) {
            $del_id = RateMaster::find()->where(['assoc_id' => $planId, 'type' => C::RATE_TYPE_STATICIP])
                            ->andWhere(['not', ['id' => $delRate]])
                            ->indexBy('id')->all();
            if (!empty($del_id)) {
                foreach ($del_id as $model) {
                    $model->delete();
                }
            }
        }
    }

}
