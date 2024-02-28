<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace console\controllers;

use common\ebl\Constants;
use common\models\ScheduleJobLogs;
use common\ebl\Constants as C;

class BaseConsoleController extends \yii\console\Controller {

    public $init_time;
    public $end_time;
    public $response;
    public $error_record;
    public $success_record;
    public $total_record;
    public $cron_name;

    public function init() {
        $this->initateSession(Constants::CONSOLE_ID);
        $this->init_time = date("Y-m-d H:i:s");
    }

    public function initateSession($id) {
        $user = \common\models\User::findOne(['id' => $id]);
        if ($user instanceof \common\models\User) {
            \Yii::$app->user->setIdentity($user);
        }
    }

    public function savetoQueue($model_data = [], $meta_data = []) {
        $model = new ScheduleJobLogs();
        $model->model = $this->cron_name;
        $model->model_name = $this->cron_name;
        $model->model_data = $model_data;
        $model->type = ScheduleJobLogs::CRON_JOB;
        $model->status = ScheduleJobLogs::JOB_DONE;
        $model->meta_data = $meta_data;
        $model->error_record = $this->error_record;
        $model->success_record = $this->success_record;
        $model->total_record = $this->total_record;
        $model->time_taken = strtotime($this->end_time) - strtotime($this->init_time);
        $model->response = $this->response;
        if ($model->validate() && $model->save()) {
            return true;
        }
    }

}
