<?php

namespace common\ebl\jobs;

use common\forms\PlanForm;
use common\models\PlanMaster;
use common\ebl\Constants as C;

class PlanMigrationJob extends BaseJobs {

    public $name;
    public $display_name;
    public $plan_type;
    public $plan_type_code;
    public $billing_type;
    public $billing_type_code;
    public $status;
    public $days;
    public $free_days;
    public $reset_type;
    public $reset_value;
    public $reset_type_code;
    public $upload;
    public $download;
    public $post_upload;
    public $post_download;
    public $limit_type_code;
    public $limit_type;
    public $limit_value;
    public $description;

//    public $rates;
//    public $rates_list;

    public function scenarios() {
        return [
            PlanMaster::SCENARIO_CREATE => ['name', 'display_name', 'plan_type', 'billing_type', 'status', 'days', 'free_days', 'reset_type', 'reset_value', 'upload', 'download', 'post_upload', 'post_download', 'limit_type', 'limit_value', 'description'],
            PlanMaster::SCENARIO_MIGRATE => ['name', 'display_name', "plan_type_code", 'billing_type_code', 'status', 'days', 'free_days', 'reset_type_code', 'reset_value', 'upload', 'download', 'post_upload', 'post_download', 'limit_type_code', 'limit_value', 'description'],
        ];
    }

    public function rules() {
        return [
            [['name', 'plan_type', 'billing_type', 'status', 'days', 'reset_type', 'reset_value', 'limit_type', 'limit_value'], 'required'],
            [['is_exclusive', 'is_promotional', 'plan_type', 'billing_type', 'status', 'days', 'free_days', 'reset_type', 'limit_type', 'added_by', 'updated_by'], 'integer'],
            [['reset_value', 'upload', 'download', 'post_upload', 'post_download', 'limit_value'], 'number'],
            [['meta_data', 'added_on', 'updated_on'], 'safe'],
            [['name', 'display_name', 'description'], 'string', 'max' => 255],
            ["plan_type_code", function ($attribute, $param, $validator) {
                    $d = array_flip(C::LABEL_PLAN_TYPE);
                    if (!empty($d[$this->plan_type_code])) {
                        $this->plan_type = $d[$this->plan_type_code];
                    } else {
                        $this->addError($attribute, "Invalid Plan type code ");
                    }
                }],
            ["billing_type_code", function ($attribute, $param, $validator) {
                    $d = array_flip(C::LABEL_BILLING_TYPE);
                    if (!empty($d[$this->billing_type_code])) {
                        $this->billing_type = $d[$this->billing_type_code];
                    } else {
                        $this->addError($attribute, "Invalid Billed Type code ");
                    }
                }],
            ["reset_type_code", function ($attribute, $param, $validator) {
                    $d = array_flip(C::RESET_LABEL);
                    if (!empty($d[$this->reset_type_code])) {
                        $this->reset_type = $d[$this->reset_type_code];
                    } else {
                        $this->addError($attribute, "Invalid reset type code ");
                    }
                }],
            ["limit_type_code", function ($attribute, $param, $validator) {
                    $d = array_flip(C::LIMIT_UNIT);
                    if (!empty($d[$this->limit_type_code])) {
                        $this->limit_type = $d[$this->limit_type_code];
                    } else {
                        $this->addError($attribute, "Invalid reset type code ");
                    }
                }],
//            ["rates_list", function ($attribute, $param, $validator) {
//                    if (!empty($this->rates_list)) {
//                        $rl = explode("|", $this->rates_list);
//                        $i = 0;
//                        foreach ($rl as $ru) {
//                            $rbu = explode(",", $ru);
//                            foreach ($rbu as $r) {
//                                $d = explode(":", $r);
//                                if (!empty($d[0]) && !empty($d[1])) {
//                                    $this->rates[$i][$d[0]] = $d[1];
//                                }
//                            }
//                            $i++;
//                        }
//                    } else {
//                        $this->addError($attribute, "Rate not provided");
//                    }
//                }]
        ];
    }

    public function save() {
        if (!$this->hasErrors()) {
            $model = new PlanForm(['scenario' => PlanMaster::SCENARIO_CREATE]);
            $model->name = $this->name;
            $model->plan_type = $this->plan_type;
            $model->display_name = $this->display_name;
            $model->plan_type = $this->plan_type;
            $model->billing_type = $this->billing_type;
            $model->status = $this->status;
            $model->days = $this->days;
            $model->free_days = $this->free_days;
            $model->reset_type = $this->reset_type;
            $model->reset_value = $this->reset_value;
            $model->upload = $this->upload;
            $model->download = $this->download;
            $model->post_download = $this->post_download;
            $model->post_upload = $this->post_upload;
            $model->limit_type = $this->limit_type;
            $model->limit_value = $this->limit_value;
            $model->description = $this->name;
            //    $model->rates = $this->rates;
            if ($model->validate() && $model->save()) {
                $this->successCnt++;
                $this->response[$this->count]['message'] = "Ok";
                return true;
            } else {
                $this->errorCnt++;
                $this->response[$this->count]["message"] = implode(" ", $model->getErrorSummary(true));
            }
        } else {
            $this->errorCnt++;
            $this->response[$this->count]["message"] = implode(" ", $this->getErrorSummary(true));
        }
        return false;
    }

    public function _execute($data) {
        $this->scenario = PlanMaster::SCENARIO_MIGRATE;
        if ($this->load($data, '') && $this->validate() && $this->save()) {
            return true;
        } else {
            if (!empty($this->errors)) {
                $this->errorCnt++;
                $this->response[$this->count]["message"] = implode(" ", $this->getErrorSummary(true));
            }
        }
    }

}
