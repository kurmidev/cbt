<?php

namespace common\ebl\jobs;

use common\forms\AssignPolicyForm;
use common\models\Operator;
use common\models\BaseModel;
use common\ebl\Constants as C;
use common\models\PlanMaster;

class PlanAllocationJob extends BaseJobs {

    public $operator_code;
    public $operator_id;
    public $rate_id;
    public $rate_code;
    public $plan_code;
    public $type = C::RATE_TYPE_BOUQUET;
    public $plan_id;
    public $operator_ids;
    public $rate_ids;

    public function scenarios() {
        return [
            BaseModel::SCENARIO_CREATE => ["operator_id", "rate_id", "plan_id"],
            BaseModel::SCENARIO_MIGRATE => ["operator_code", "rate_code", "plan_code"],
            BaseModel::SCENARIO_BULK_ACTIVITY => ["operator_ids", "rate_ids"],
        ];
    }

    public function rules() {
        return [
            [["operator_code", "rate_code"], "required"],
            ["plan_code", function ($attribute, $param, $validator) {
                    $d = PlanMaster::find()->where(['OR', ['name' => trim($this->plan_code)], ['code' => trim($this->plan_code)]])->one();
                    if ($d instanceof PlanMaster) {
                        $this->plan_id = $d->id;
                    } else {
                        $this->addError($attribute, "Invalid plan code.");
                    }
                }],
            ["rate_code", function ($attribute, $param, $validator) {
                    $d = \common\models\RateMaster::findOne(['name' => $this->rate_code, "assoc_id" => $this->plan_id, "type" => C::RATE_TYPE_BOUQUET]);
                    if ($d instanceof \common\models\RateMaster) {
                        $this->rate_id = $d->id;
                    } else {
                        $this->addError($attribute, "Invalid rate code.");
                    }
                }],
            ["operator_code", function ($attribute, $param, $validator) {
                    $d = Operator::find()->where(['OR', ['name' => trim($this->operator_code)], ['code' => trim($this->operator_code)]])->one();
                    if ($d instanceof Operator) {
                        $this->operator_id = $d->id;
                    } else {
                        $this->addError($attribute, "Invalid franchise code.");
                    }
                }],
            [["operator_ids", "rate_ids"], "required", "on" => BaseModel::SCENARIO_BULK_ACTIVITY],
            [["operator_ids", "rate_ids"], 'each', 'rule' => ['integer'], "on" => BaseModel::SCENARIO_BULK_ACTIVITY],
        ];
    }

    public function save() {
        if (!$this->hasErrors()) {
            $model = OperatorAssoc::findOne(['assoc_id' => $this->plan_id, 'operator_id' => $this->operator_id, 'type' => $this->type]);
            if (!$model instanceof OperatorAssoc) {
                $model = new OperatorAssoc(['scenario' => OperatorAssoc::SCENARIO_CREATE]);
                $model->assoc_id = $this->plan_id;
                $model->operator_id = $this->operator_id;
                $model->type = $this->type;
                if ($model->validate() && $model->save()) {
                    $p = new AssignPolicyForm();
                    $p->type = $this->type;
                    $p->assignRates($model, $this->rate_id);
                    $this->successCnt++;
                    $this->response[$this->count]['message'] = "Ok";
                    return true;
                } else {
                    $this->errorCnt++;
                    $this->response[$this->count]["message"] = implode(" ", $model->getErrorSummary(true));
                }
            } else {
                $this->successCnt++;
                $this->response[$this->count]['message'] = "Already Assigned";
            }
        } else {
            print_r($this->errors);
            $this->errorCnt++;
            $this->response[$this->count]["message"] = implode(" ", $this->getErrorSummary(true));
        }
        return false;
    }

    //put your code here
    public function _execute($data) {
        $this->scenario = Operator::SCENARIO_MIGRATE;
        if ($this->load($data, '') && $this->validate() && $this->save()) {
            return true;
        } else {
            if (!empty($this->errors)) {
                $this->errorCnt++;
                $this->response[$this->count]["message"] = implode(" ", $this->getErrorSummary(true));
            }
        }
    }

    public function _executeBulk() {
        parent::_executeBulk();
        $this->scenario = BaseModel::SCENARIO_BULK_ACTIVITY;
        if (!$this->hasErrors()) {
            $rates = \common\models\RateMaster::find()->where(["id" => $this->rate_ids])->indexBy("id")->all();
            $operators = Operator::find()->where(['id' => $this->operator_ids])->indexBy('id')->asArray()->all();
            foreach ($rates as $rid => $rate) {
                $this->scenario = BaseModel::SCENARIO_CREATE;
                foreach ($operators as $operator_id => $operator) {
                    $this->rate_id = $rid;
                    $this->operator_id = $operator_id;
                    $this->plan_id = $rate->assoc_id;
                    $this->response[$this->count] = [
                        "rate_code" => $rate->name,
                        "plan" => $rate->plan->name,
                        "operator" => $operator['name']
                    ];
                    $d = $this->save();
                    $this->count++;
                }
            }
            return $d;
        }
        return false;
    }

}
