<?php

namespace common\ebl\jobs;

use common\models\ScheduleJobLogs;
use common\component\Utils as U;
use common\models\BaseModel;

abstract class BaseFormJobs extends \yii\base\Model implements \yii\queue\JobInterface {

    public $sjl_id;
    public $scmdl;
    public $startTime;
    public $endTime;
    public $response = [];
    public $successCnt = 0;
    public $errorCnt = 0;
    public $total_record = 0;
    public $count = 0;
    public $message;

    public function initiateLogin() {

        $this->scmdl = ScheduleJobLogs::findOne(['_id' => (int) $this->sjl_id]);
        if ($this->scmdl instanceof ScheduleJobLogs) {
            $user = \common\models\User::findOne(['id' => $this->scmdl->added_by]);
            if ($user instanceof \common\models\User) {
                \common\models\User::$loggedInUser = $user->id;
                \Yii::$app->user->setIdentity($user);
            }
        }
        parent::init();
    }

    public function execute($queue) {
        $this->initiateLogin();
        $this->startTime = time();
        $this->_execute();
        $timeTaken = U::dateDiff($this->startTime, time(), "s");
        ScheduleJobLogs::updateAll([
            'total_record' => $this->count,
            'error_record' => $this->errorCnt,
            'success_record' => $this->successCnt,
            'time_taken' => $timeTaken,
            "status" => ScheduleJobLogs::JOB_DONE,
            'response' => $this->response,
            "message" => $this->message
                ], ["_id" => (int) $this->scmdl->_id]);
    }

    public abstract function _execute();

    public function rrerun() {
        if (!empty($this->scmdl)) {
            $data = \yii\helpers\ArrayHelper::merge($this->scmdl->model_data, ['sjl_id' => $this->scmdl->_id]);
            $obj = new $this->scmdl->model($data);
            $obj->execute();
        }
    }

    public function _scheduleBulk($class,$data) {
        if (!$this->hasErrors()) {
            $model = new \common\models\ScheduleJobLogs();
            $model->model = $class;
            $model->model_data = $data;
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
    
    

}
