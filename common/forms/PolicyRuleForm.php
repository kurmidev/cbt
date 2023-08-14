<?php

namespace common\forms;

use common\models\PlanPolicy;

class PolicyRuleForm extends \yii\base\Model {

    public $id;
    public $name;
    public $days;
    public $start_time;
    public $end_time;
    public $pre_upload;
    public $pre_download;
    public $post_upload;
    public $post_download;
    public $pre_burst_threshhold;
    public $pre_burst_time;
    public $pre_burst_limit;
    public $pearing_in;
    public $pearing_out;
    public $status;
    public $limit_type;
    public $limit_value;
    public $limit_unit;
    public $post_burst_threshhold;
    public $post_burst_time;
    public $post_burst_limit;

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            PlanPolicy::SCENARIO_CREATE => ['id', 'days', 'start_time', 'end_time', 'pre_upload', 'pre_download', 'post_upload', 'post_download', 'name', 'status', 'burst_threshhold', 'burst_time', 'burst_limit', 'limit_type', 'limit_value', 'limit_unit', 'status', 'pre_burst_threshhold', 'pre_burst_time', 'pre_burst_limit', 'post_burst_threshhold', 'post_burst_time', 'post_burst_limit'],
            PlanPolicy::SCENARIO_CONSOLE => ['id', 'days', 'start_time', 'end_time', 'pre_upload', 'pre_download', 'post_upload', 'post_download', 'name', 'status', 'burst_threshhold', 'burst_time', 'burst_limit', 'limit_type', 'limit_value', 'limit_unit', 'status', 'pre_burst_threshhold', 'pre_burst_time', 'pre_burst_limit', 'post_burst_threshhold', 'post_burst_time', 'post_burst_limit'],
            PlanPolicy::SCENARIO_UPDATE => ['id', 'days', 'start_time', 'end_time', 'pre_upload', 'pre_download', 'post_upload', 'post_download', 'name', 'status', 'burst_threshhold', 'burst_time', 'burst_limit', 'limit_type', 'limit_value', 'limit_unit', 'status', 'pre_burst_threshhold', 'pre_burst_time', 'pre_burst_limit', 'post_burst_threshhold', 'post_burst_time', 'post_burst_limit'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['start_time', 'end_time', 'pre_upload', 'pre_download', 'post_upload', 'post_download', 'days', 'name', 'limit_type', 'limit_value', 'limit_unit'], 'required'],
            [['total_time', 'pre_upload', 'pre_download', 'post_upload', 'post_download', 'status', 'limit_type', 'limit_value', 'limit_unit'], 'integer'],
            [['pre_burst_threshhold', 'pre_burst_time', 'pre_burst_limit', 'post_burst_threshhold', 'post_burst_time', 'post_burst_limit', 'pearing_in', 'pearing_out', 'added_on', 'updated_on', 'id'], 'safe'],
            [['start_time', 'end_time', 'pre_upload', 'pre_download', 'post_upload', 'post_download'], 'unique'],
            [['name'], 'unique'],
            ['days', 'in', 'range' => array_keys(\common\ebl\Constants::LABEL_DAYS_TYPES)],
            [['burst_threshhold', 'burst_time', 'burst_limit', 'pearing_in', 'pearing_out'], 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            [['start_time', 'end_time'], function($attribute, $params, $validator) {
                    if (\common\component\Utils::getTotalHrs($this->start_time, $this->end_time) > "23:59:59") {
                        $this->addError($attribute, 'Invalid Start and End Time.');
                    }
                }]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'days' => 'Applicable Days',
            'start_time' => "Start Time",
            'end_time' => 'End Time',
            'pre_upload' => 'Pre Upload(MB)',
            'pre_download' => 'Pre Download(MB)',
            'post_upload' => 'Post Upload(MB)',
            'post_download' => 'Post Download(MB)',
            'name' => 'Rule Name',
            'status' => 'Status',
            'pre_burst_threshhold' => 'Burst ThreshHold(Kb)',
            'pre_burst_time' => 'Burst Time(sec)',
            'pre_burst_limit' => 'Burst Limit(Kb)',
            'post_burst_threshhold' => 'Burst ThreshHold(Kb)',
            'post_burst_time' => 'Burst Time(sec)',
            'post_burst_limit' => 'Burst Limit(Kb)',
            'limit_type' => 'Limit Type',
            'limit_value' => 'Limit Value',
            'limit_unit' => 'Limit Unit'
        ];
    }

    public function save($runValidation = true, $attributeNames = null) {
        if (!$this->hasErrors()) {
            $model = new PlanPolicy(['scenario' => PlanPolicy::SCENARIO_CREATE]);
            if ($this->id) {
                $model = PlanPolicy::findOne($this->id);
                $model->setScenario(PlanPolicy::SCENARIO_UPDATE);
            }
            $model->load($this->attributes, '');
            $model->extra_config = [
                'pre_burst_threshhold' => $this->pre_burst_threshhold ?: 0,
                'pre_burst_time' => $this->pre_burst_time ?: "00:00:00",
                'pre_burst_limit' => $this->pre_burst_limit ?: 0,
                'post_burst_threshhold' => $this->post_burst_threshhold ?: 0,
                'post_burst_time' => $this->post_burst_time ?: "00:00:00",
                'post_burst_limit' => $this->post_burst_limit ?: 0,
            ];
            if ($model->validate() && $model->save()) {
                return $model;
            } else {
                $this->addErrors($model->errors);
            }
        }
    }

}
