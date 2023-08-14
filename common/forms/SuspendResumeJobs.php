<?php

namespace common\forms;

use common\models\CustomerAccount;
use common\forms\AccountForm;

class SuspendResumeJobs extends \common\ebl\jobs\BaseFormJobs {

    public $account_ids;
    public $is_refund;
    public $remark;
    public $status;
    public $job_id;

    public function rules(): array {
        return [
            [['account_ids', 'is_refund', 'remark', 'status'], 'required'],
            ['account_ids', 'each', 'rule' => ['integer']],
            [['is_refund', 'status'], 'integer'],
            [['remark'], "string"]
        ];
    }

    public function scheduleBulk() {
        $class = self::class;
        $data = ["account_ids" => $this->account_ids, "status" => $this->status, "remark" => $this->remark, "is_refund" => $this->is_refund];
        $this->_scheduleBulk($class, $data);
        return $this->_scheduleBulk($class, $data);
    }

    public function save() {
        if (!$this->hasErrors()) {
            $status = $this->status ? 0 : 1;
            $accountObj = CustomerAccount::find()->where(['id' => $this->account_ids, 'status' => $status]);
            $this->total_record = $accountObj->count();
            foreach ($accountObj->batch() as $accounts) {
                foreach ($accounts as $account) {
                    $model = new AccountForm(['scenario' => AccountForm::SCENARIO_SUSPEND_RESUME]);
                    $model->id = $account->id;
                    $model->remark = $this->remark;
                    $model->is_refund = $this->is_refund;
                    $this->response[$this->count] = [
                        "account_id" => $account->id,
                        "username" => $account->username,
                        "remark" => $this->remark,
                        "is_refund" => $this->is_refund
                    ];
                    $model->status = $this->status;
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
    }

    public function _execute() {
        $this->save();
    }

}
