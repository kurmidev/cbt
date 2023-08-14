<?php

namespace common\forms;

class BulkRefreshJobs extends \common\ebl\jobs\BaseFormJobs {

    public $account_ids;

    public function rules(): array {
        return [
            [["account_ids"], "required"],
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
            $accountObj = CustomerAccount::find()->where(['id' => $this->account_ids]);
            $this->total_record = $accountObj->count();
            foreach ($accountObj->batch() as $accounts) {
                foreach ($accounts as $account) {
                    //need to implement refresh job here
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
