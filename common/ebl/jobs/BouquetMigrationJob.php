<?php

namespace common\ebl\jobs;

use common\forms\PlanForm;
use common\models\Bouquet;
use common\ebl\Constants as C;

class BouquetMigrationJob extends BaseJobs {

    public $name;
    public $status;
    public $days;
    public $bill_type;
    public $billing_type;
    public $description;
    public $is_online;
    public $type;
    public $bouquet_type;
    public $assets;
    public $asset_mapping;
    public $rates;
    public $rate_list;

    public function scenarios() {
        return [
            Bouquet::SCENARIO_CREATE => ['name', 'status', 'type', 'bill_type', 'description', 'days', 'is_online', 'rates', 'asset_mapping'],
            Bouquet::SCENARIO_MIGRATE => ['name', 'bouquet_type', 'billing_type', 'description', 'days', 'is_online', 'rate_list', 'assets'],
        ];
    }

    public function rules() {
        return [
            [['name', 'status', 'bouquet_type', 'billing_type', 'days', 'is_online', 'rate_list', 'assets'], 'required'],
            [['type', 'bill_type', 'status', 'days'], 'integer'],
            [['meta_data',], 'safe'],
            [['name', 'description'], 'string', 'max' => 255],
            ["billing_type", function ($attribute, $param, $validator) {
                    $d = array_flip(array_map('strtolower', C::LABEL_BILLING_TYPE));

                    if (!empty($d[strtolower($this->billing_type)])) {
                        $this->bill_type = $d[strtolower($this->billing_type)];
                    } else {
                        $this->addError($attribute, "Invalid billing type code ");
                    }
                }],
            ["bouquet_type", function ($attribute, $param, $validator) {
                    $d = array_flip(array_map('strtolower', C::LABEL_PLAN_TYPE));
                    if (!empty($d[strtolower($this->bouquet_type)])) {
                        $this->type = $d[strtolower($this->bouquet_type)];
                    } else {
                        $this->addError($attribute, "Invalid Bouquet Type code ");
                    }
                }],
            ["assets", function ($attribute, $param, $validator) {
                    $assets = explode("|", $this->assets);
                    $assetList = \common\models\BouquetAssets::find()->where(['OR', ['name' => $assets], ['code' => $assets]])->indexBy('id')->all();
                    if (!empty($assetList)) {
                        $this->asset_mapping = array_keys($assetList);
                    }
                }],
            ["rate_list", function ($attribute, $param, $validator) {
                    if (!empty($this->rate_list)) {
                        $rl = explode("|", $this->rate_list);
                        $i = 0;
                        foreach ($rl as $ru) {
                            $rbu = explode(",", $ru);
                            foreach ($rbu as $r) {
                                $d = explode(":", $r);
                                if (!empty($d[0]) && !empty($d[1])) {
                                    $this->rates[$i][$d[0]] = $d[1];
                                }
                            }
                            $i++;
                        }
                    } else {
                        $this->addError($attribute, "Rate not provided");
                    }
                }]
        ];
    }

    public function save() {
        
        if (!$this->hasErrors()) {
            $model = new \common\forms\BouquetForm(['scenario' => Bouquet::SCENARIO_CREATE]);
            $model->name = $this->name;
            $model->type = $this->type;
            $model->bill_type = $this->bill_type;
            $model->description = $this->description;
            $model->days = $this->days;
            $model->status = C::STATUS_ACTIVE;
            $model->is_online = $this->is_online;
            $model->asset_mapping = $this->asset_mapping;
            $model->rates = $this->rates;
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
        $this->scenario = Bouquet::SCENARIO_MIGRATE;
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
