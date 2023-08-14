<?php

namespace common\forms;

use common\models\Operator;
use common\models\OperatorRates;
use yii\helpers\ArrayHelper;
use common\models\RateMaster;

class AssignPolicyForm extends \common\ebl\jobs\BaseFormJobs {

    public $rate_ids;
    public $operator_ids;
    public $type;
    public $flow;

    const ASSIGN_POLICY = 1;
    const DEASSIGN_POLICY = 2;

    public function scenarios() {
        return [
            "assign-policy" => ["rate_ids", "operator_ids", "type", "flow"],
            "deassign-policy" => ["rate_ids", "operator_ids", "type", "flow"],
        ];
    }

    public function rules() {
        return [
            [["rate_ids", "operator_ids", 'type'], 'required', 'on' => "assign-policy"],
            [['type', 'flow'], 'integer'],
            [["operator_ids", "rate_ids"], 'each', 'rule' => ['integer']],
            ["rate_ids", "validateRates", 'on' => 'assign-policy'],
        ];
    }

    public function validateRates($attribute, $params, $validator) {
        if (count(array_filter($this->rate_ids)) == 0) {
            $this->addError("rate_ids", "Plase assign rate to franchise");
        }
    }

    public function attributeLabels() {
        return [
            "rated_ids" => "Rate",
            "operator_ids" => "Franchise",
            "type" => "Type",
            "flow" => "Flow"
        ];
    }

    public function scheduleBulk() {
        if (!$this->hasErrors()) {
            $model = new \common\models\ScheduleJobLogs();
            $model->model = AssignPolicyForm::class;
            $model->model_data = ["rate_ids" => $this->rate_ids, "operator_ids" => $this->operator_ids, "type" => $this->type, "flow" => $this->flow];
            $model->model_name = "AssignPolicyForm";
            $model->type = \common\models\ScheduleJobLogs::DATA_UPLOAD;
            $model->status = \common\models\ScheduleJobLogs::JOB_PENDING;
            $model->total_record = $model->error_record = $model->success_record = 0;
            if ($model->validate() && $model->save()) {
                $model->scheduleJob();
                return true;
            }
        }
        return false;
    }

    public function save() {
        if (!$this->hasErrors()) {
            if ($this->type == self::ASSIGN_POLICY) {
                $this->assignBouquet();
            } else if ($this->type == self::DEASSIGN_POLICY) {
                $this->deassignBouquet();
            }
        }
        return false;
    }

    public function getOperatorList($ids) {
        $operators = Operator::find()->where(['id' => $ids])
                        ->select(['id', 'ro_id', 'distributor_id'])
                        ->indexBy('id')->asArray()->all();

        $operator = $operator_ids = [];
        if (!empty($operators)) {
            $operator_ids = ArrayHelper::merge(
                            array_keys($operators), //get all franchise
                            ArrayHelper::getColumn($operators, 'distributor_id'), //get all distributor
                            ArrayHelper::getColumn($operators, 'ro_id') //get all ro
            );
            $operator_ids = array_unique($operator_ids);
            $operator = Operator::find()->where(['id' => $operator_ids])->indexBy('id');
        }
        return [$operator_ids, $operator];
    }

    public function getRateList($ids) {
        return RateMaster::find()->where(['id' => $ids])->indexBy('id')->all();
    }

    public function _execute() {
        $this->save();
    }

    public function deassignBouquet() {
        $rate_ids = !empty($this->rate_ids) ? array_filter($this->rate_ids) : [];
        $operator_ids = !empty($this->operator_ids) ? array_filter($this->operator_ids) : [];
        if (!empty($rate_ids) && !empty($operator_ids)) {
            $model = OperatorRates::find()->where(['operator_id' => $operator_ids, 'assoc_id' => $rate_ids]);
            foreach ($model->batch() as $bouqets) {
                foreach ($bouqets as $bouqet) {
                    $this->response[$this->count] = [
                        "franchise" => $bouqet->operator->name,
                        "bouquet" => $bouqet->bouquet->name
                    ];
                    if ($bouqet->delete()) {
                        $this->successCnt++;
                        $this->total_record++;
                        $this->response[$this->count]['message'] = "Ok";
                    } else {
                        $this->errorCnt++;
                        $this->total_record++;
                        $this->response[$this->count]["message"] = implode(" ", $model->getErrorSummary(true));
                    }
                    $this->count++;
                }
            }
            return true;
        }
        return false;
    }

    public function assignBouquet() {
        $rate_ids = !empty($this->rate_ids) ? array_filter($this->rate_ids) : [];
        $operator_ids = !empty($this->operator_ids) ? array_filter($this->operator_ids) : [];
        if (!empty($rate_ids) && !empty($operator_ids)) {
            list( $assignOperatorList, $optDetails) = $this->getOperatorList($operator_ids);
            $rateList = $this->getRateList($rate_ids);
            foreach ($optDetails->batch() as $operatorDetails) {
                foreach ($operatorDetails as $operator_id => $optDetail) {
                    foreach ($rateList as $rate) {
                        $model = OperatorRates::findOne(['operator_id' => $operator_id, 'rate_id' => $rate->id]);
                        if (!$model instanceof OperatorRates) {
                            $model = new OperatorRates(["scenario" => OperatorRates::SCENARIO_CREATE]);
                            $model->operator_id = $operator_id;
                            $model->assoc_id = $rate->assoc_id;
                            $model->rate_id = $rate->id;
                            $model->type = 1;
                            $model->amount = $rate->amount;
                            $model->tax = $rate->tax;
                            $model->mrp = $rate->mrp;
                            $model->mrp_tax = $rate->mrp_tax;
                            if ($model->validate() && $model->save()) {
                                $this->successCnt++;
                                $this->total_record++;
                                $this->response[$this->count]['message'] = "Ok";
                            } else {
                                $this->errorCnt++;
                                $this->total_record++;
                                $this->response[$this->count]["message"] = implode(" ", $model->getErrorSummary(true));
                            }
                        } else {
                            $this->successCnt++;
                            $this->total_record++;
                            $this->response[$this->count]['message'] = "Already assigned";
                        }
                        echo $this->response[$this->count]['message'] . PHP_EOL;
                        $this->count++;
                    }
                }
            }
            return true;
        }
        return false;
    }

}
