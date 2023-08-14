<?php

namespace common\ebl\jobs;

use common\models\ScheduleJobLogs;
use common\component\Utils as U;
use common\models\BaseModel;

abstract class BaseJobs extends \yii\base\Model implements \yii\queue\JobInterface {

    public $sjl_id;
    public $scmdl;
    public $startTime;
    public $endTime;
    public $response = [];
    public $successCnt = 0;
    public $errorCnt = 0;
    public $count = 0;
    public $message;

    public function initiateLogin() {

        $this->scmdl = ScheduleJobLogs::findOne(['_id' => (int) $this->sjl_id]);
        if ($this->scmdl instanceof ScheduleJobLogs) {
            $user = \common\models\User::findOne(['id' => $this->scmdl->added_by]);
            if ($user instanceof \common\models\User) {
                \common\models\User::$loggedInUser = $user;
                \Yii::$app->user->setIdentity($user);
            }
        }
        parent::init();
    }

    public function execute($queue) {
        $this->initiateLogin();
        $this->startTime = time();
        switch ((int) $this->scmdl->type) {
            case ScheduleJobLogs::FILE_UPLOAD:
                $this->_executeFile();
                break;
            case ScheduleJobLogs::DATA_UPLOAD:
                $this->_executeBulk();
                break;
        }
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

    public abstract function _execute($data);

    public function _executeFile() {
        $scenario = $this->scenarios();

        if (file_exists($this->scmdl->file_path)) {
            try {
                $file = fopen($this->scmdl->file_path, "r");
                $header = [];
                while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                    if ($this->count == 0) {
                        $header = $data;
                        $header = array_map('trim', $header);
                    } else {
                        $data = array_map('trim', $data);
                        $d = array_combine($header, $data);
                        $this->response[$this->count] = $d;
                        $is_valid_header = array_diff($scenario[BaseModel::SCENARIO_MIGRATE], $header);
                        if (!empty($this->scmdl->model_data)) {
                            $d = \yii\helpers\ArrayHelper::merge($d, $this->scmdl->model_data);
                        }
                        if (empty($is_valid_header)) {
                            $this->_execute($d);
                            echo "Total record process is success:{$this->successCnt} error:{$this->errorCnt} processed {$this->count}" . PHP_EOL;
                        } else {
                            $this->message = "Could not process file beacuse of Invalid headers formats " . implode(",", $is_valid_header);
                            break;
                        }
                    }
                    $this->count++;
                }
                $this->message = !empty($this->message) ? $this->message : "Total record process is {$this->successCnt}/{$this->count}";
            } catch (\Exception $ex) {
                $this->message = $ex->getMessage();
                print_r($ex);
            }
        } else {
            $this->message = " file not found.";
        }
    }

    public function _executeBulk() {
        
    }

}
