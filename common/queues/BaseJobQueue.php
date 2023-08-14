<?php

namespace common\queues;

use app\models\ScheduleJobLogs;

class BaseJobQueue extends \yii\base\BaseObject implements \yii\queue\JobInterface {

    public $sjl_id;
    public $collection;
    public $count;
    public $s_count;
    public $e_count;
    public $error = [];
    public $success = [];
    public $msg;

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->collection = ScheduleJobLogs::findOne(['_id' => $this->sjl_id]);
        if (!empty($this->collection)) {
            $user = \common\models\User::findOne($this->collection->added_by);
            if ($user instanceof common\models\User) {
                \Yii::$app->user->setIdentity($user);
            }
        }
    }

    public function getTtr() {
        return 15 * 60;
    }

    public function canRetry($attempt, $error) {
        return ($attempt < 2) && ($error instanceof TemporaryException);
    }

    public function _execute($queue) {
        
    }

    public function execute($queue) {
        try {
            $response = $this->_execute($queue);
            if (!empty($response)) {
                ScheduleJobLogs::updateAll([
                    "total_record" => $this->count,
                    "error_record" => $this->s_count,
                    "success_record" => $this->e_count,
                    "response" => $response,
                    "status" => ScheduleJobLogs::JOB_DONE,
                    "time_taken" => \Yii::getLogger()->getElapsedTime()
                        ], ['_id' => $this->sjl_id]);
            }
        } catch (\Exception $ex) {

            ScheduleJobLogs::updateAll([
                "total_record" => $this->count,
                "error_record" => $this->s_count,
                "success_record" => $this->e_count,
                "response" => [
                    "error_message" => $ex->getMessage(),
                    "error_file" => $ex->getFile(),
                    "error_line" => $ex->getLine(),
                    "error" => $ex->getTraceAsString()
                ],
                "status" => ScheduleJobLogs::JOB_ERROR,
                "time_taken" => \Yii::getLogger()->getElapsedTime()
                    ], ['_id' => $this->sjl_id]);
        }
    }

}
