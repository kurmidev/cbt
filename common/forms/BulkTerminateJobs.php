<?php

namespace common\forms;

class BulkTerminateJobs extends \common\ebl\jobs\BaseFormJobs {

    public $account_ids;
    public $job_id;
    public $remark;

    public function rules(): array {
        return [
            [["account_ids"], "required"],
            [['remark'],'safe'],
            ['account_ids', 'each', 'rule' => ['integer']]
        ];
    }

    public function scheduleBulk() {
        $class = self::class;
        $data = ["account_ids" => $this->account_ids];
        $this->_scheduleBulk($class, $data);
        return $this->_scheduleBulk($class, $data);
    }

    public function save() {
        if (!$this->hasErrors()) {
            $currentUser = \common\models\User::loggedInUserName();
            $date = date("Y-m-d");
            $accountObj = \common\models\CustomerAccount::find()->andWhere(['id' => $this->account_ids]);
            $this->total_record = $accountObj->count();

            foreach ($accountObj->batch() as $accounts) {
                foreach ($accounts as $account) {
                    $acc = new AccountForm(['scenario' => AccountForm::SCENARIO_TERMINATE]);
                    $acc->id = $account->id;
                    $acc->remark = "{$account->username} terminated by user {$currentUser} on {$date} ";
                    $this->response[$this->count] = [
                        "username" => $account->username,
                        "account_id" => $account->id,
                        "remark" => ''
                    ];
                    if ($acc->terminateAccount()) {
                        $this->successCnt++;
                        $this->response[$this->count]['remark'] = $acc->message;
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
