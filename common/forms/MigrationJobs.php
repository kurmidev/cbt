<?php

namespace common\forms;

use common\models\ScheduleJobLogs;
use common\ebl\Constants as C;

class MigrationJobs extends \yii\base\Model {

    public $type;
    public $model;
    public $model_data;
    public $file;
    public $filePath;
    public $id;

    // public $dwnFields;

    public function scenarios() {
        return [
            ScheduleJobLogs::SCENARIO_CREATE => ["type", "model", "file", "filePath", 'id', 'model_data'],
            ScheduleJobLogs::SCENARIO_UPDATE => ["type", "model", "file", "filePath", 'id', 'model_data'],
        ];
    }

    public function rules() {
        return [
            [["type", "model", "type"], 'required'],
            [["type", "id"], "integer"],
            [["model"], "string"],
            [['file'], 'file', 'extensions' => 'csv'],
            [["file", 'filePath', 'model_data'], "safe"]
        ];
    }

    public function setDwnFields($dwfields) {
        $this->dwnFields = $dwfields;
    }

    public function getDwnFields() {
        if (!empty($this->dwnFields))
            return $this->dwnFields;

        $result = [];
        foreach (C::LABEL_JOB_MODELS as $model => $label) {
            $m = new $model();
            if (!empty($m)) {
                $s = $m->scenarios();
                $result[$model] = [
                    "cols" => !empty($s[\common\models\BaseModel::SCENARIO_MIGRATE]) ? $s[\common\models\BaseModel::SCENARIO_MIGRATE] : [],
                    "file" => str_replace(" ", "_", $label)
                ];
            }
        }
        return $result;
    }


    public function save() {
        if (!$this->hasErrors()) {
            $model = new ScheduleJobLogs();
            $model->model = $this->model;
            $model->model_name = C::BULK_JOB_MODELS[$this->model];
            $model->model_data = !empty($this->model_data) ? $this->model_data : [];
            $model->type = $this->type;
            $model->status = ScheduleJobLogs::JOB_PENDING;
            $model->meta_data = [];
            $model->error_record = $model->success_record = $model->total_record = 0;
            $model->time_taken = 0;
            $model->response = [];
            
            $file = \yii\web\UploadedFile::getInstance($this, 'file');
            if ($model->validate() && !$file->hasError && $model->save()) {
                $this->id = $model->_id;
                $this->filePath = \Yii::getAlias("@runtime/uploads/{$model->_id}.{$file->extension}");
                if ($file->saveAs($this->filePath)) {
                    ScheduleJobLogs::updateAll(['file_path' => $this->filePath], ["_id" => $model->_id]);
                    $model->scheduleJob();
                    return true;
                }
            } else {
                if ($file->hasError) {
                    $model->addError("file", "File not proper or size exceed 2MB");
                }
            }
        }
        return false;
    }

}
