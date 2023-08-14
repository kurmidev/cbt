<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * This is the model class for collection "schedule_job_logs".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $model
 * @property mixed $model_name
 * @property mixed $model_data
 * @property mixed $type
 * @property mixed $status
 * @property mixed $job_id
 * @property mixed $meta_data
 * @property mixed $total_record
 * @property mixed $error_record
 * @property mixed $success_record
 * @property mixed $time_taken
 * @property mixed $response
 * @property mixed $message
 * @property mixed $locked_on
 * @property mixed $added_on
 * @property mixed $added_by
 * @property mixed $updated_on
 * @property mixed $updated_by
 */
class ScheduleJobLogs extends \common\models\BaseMongoModel {

    const JOB_PENDING = 1;
    const JOB_SCHEDULE = 2;
    const JOB_PROCESS = 2;
    const JOB_DONE = 3;
    const JOB_ERROR = 4;
    const FILE_UPLOAD =1;
    const DATA_UPLOAD =2;
    const CRON_JOB = 3;

    /**
     * {@inheritdoc}
     */
    public static function collectionName() {
        return 'schedule_job_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function attributes() {
        return [
            '_id',
            'model',
            'model_name',
            'model_data',
            'type',
            'job_types',
            'status',
            'job_id',
            'meta_data',
            'total_record',
            'error_record',
            'success_record',
            'time_taken',
            'response',
            "file_path",
            'locked_on',
            'message',
            'added_on',
            'added_by',
            'updated_on',
            'updated_by',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['model', 'model_name', 'status','type'], 'required'],
            [['added_on', 'model_data', 'added_by', 'updated_on', 'updated_by', 'meta_data', 'error_record', 'success_record', 'response', 'locked_on', 'job_id', 'time_taken', 'total_record', "file_path", "message","job_types"], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            '_id' => 'ID',
            'model' => 'Model',
            'model_name' => 'Model Name',
            'model_data' => 'Model Data',
            'status' => 'Status',
            'job_id' => 'Job ID',
            'time_taken' => 'Time  Taken',
            'meta_data' => 'Meta Data',
            'total_record' => 'Total Record',
            'error_record' => 'Error Record',
            'success_record' => 'Success Record',
            'response' => 'Response',
            "job_types"=>"Job Types",
            'file_path' => 'File Path',
            'locked_on' => 'Locked On',
            'added_on' => 'Added On',
            'added_by' => 'Added By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }

    public function scheduleJob() {
        try {
            $data = \yii\helpers\ArrayHelper::merge($this->model_data, ['sjl_id' => $this->_id]);
            $job_id = Yii::$app->queue->push(new $this->model($data));
            $status = self::JOB_SCHEDULE;
            if (Yii::$app->queue->isWaiting($job_id)) {
                $status = self::JOB_PENDING;
            }
            if (Yii::$app->queue->isReserved($job_id)) {
                $status = self::JOB_PROCESS;
            }
            self::updateAll(['job_id' => $job_id, 'status' => $status, 'locked_on' => strtotime('now')], ['_id' => $this->_id]);
        } catch (Exception $ex) {
            
        }
    }

    public function beforeSave($insert) {
        $this->_id = \common\models\CodeSequence::getSequence(self::collectionName());
        return parent::beforeSave($insert);
    }

    public function getStatusLabel() {
        return !empty(C::LABEL_JOB_STATUS[$this->status]) ? C::LABEL_JOB_STATUS[$this->status] : $this->status;
    }

}
