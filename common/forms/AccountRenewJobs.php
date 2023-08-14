<?php

namespace common\forms;

use common\models\CustomerAccount;
use common\forms\AccountForm;

class AccountRenewJobs extends \common\ebl\jobs\BaseFormJobs {

    public $account_ids;
    public $plan_ids;
    public $job_id;

    public function rules(): array {
        return [
            [['account_ids'], 'required'],
            ['account_ids', 'each', 'rule' => ['integer']],
        ];
    }

    public function scheduleBulk() {
        if (!$this->hasErrors()) {
            $model = new \common\models\ScheduleJobLogs();
            $model->model = self::class;
            $model->model_data = ["account_ids" => $this->account_ids, "plan_ids" => $this->plan_ids];
            $model->model_name = self::className();
            $model->type = \common\models\ScheduleJobLogs::DATA_UPLOAD;
            $model->status = \common\models\ScheduleJobLogs::JOB_PENDING;
            $model->total_record = $model->error_record = $model->success_record = 0;
            if ($model->validate() && $model->save()) {
                $model->scheduleJob();
                $this->job_id = $model->_id;
                return true;
            }
        }
        return false;
    }

    public function save() {
        if (!$this->hasErrors()) {
            $accounts = CustomerAccount::find()->where(['id' => $this->account_ids])->needtoRenew();
            $this->total_record = $accounts->count();
            foreach ($accounts->batch() as $account) {
                foreach ($account as $acc) {
                    $model = new AccountForm(['scenario' => AccountForm::SCENARIO_RENEW]);
                    $model->operator_id = $acc->operator_id;
                    $model->id = $acc->id;
                    $model->plan_id = $acc->lastBasePlan->plan_id;
                    $model->action_type = \common\ebl\RateCalculation::ACTION_TYPE_RENEW;
                    $this->response[$this->count] = [
                        "account_id"=> $acc->id,
                        "username" => $acc->username,
                        "plan" => $acc->lastBasePlan->plan->name
                    ];
                    if ($model->validate() && $model->save()) {
                        $this->successCnt++;
                        $this->response[$this->count]['message'] = "Ok";
                    } else {
                        $this->errorCnt++;
                        $this->response[$this->count]["message"] = implode(" ", $model->getErrorSummary(true));
                    }
                    $this->count++;
                }
            }
            return true;
        } 
        return false;
    }

    public function _execute() {
        $this->save();
    }

}
