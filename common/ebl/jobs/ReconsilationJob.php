<?php

namespace common\ebl\jobs;

use common\ebl\Constants as C;
use common\models\OptPaymentReconsile;

class ReconsilationJob extends BaseJobs {

    public $id;
    public $receipt_no;
    public $deposited_bank;
    public $deposited_by;
    public $desposited_on;
    public $realized_on;
    public $realised_by;
    public $status;
    public $status_int;
    public $deposited_by_id;
    public $realised_by_id;
    public $type;

    public function scenarios() {
        $migScen = ["receipt_no", "deposited_bank", "deposited_by", "desposited_on", 'status'];
        if ($this->type == 2) {
            $migScen = ["receipt_no", "realized_on", "realised_by", 'status'];
        }
        return [
            OptPaymentReconsile::SCENARIO_CREATE => ["receipt_no", "deposited_bank", "deposited_by", "desposited_on", 'status_int', "id", 'deposited_by_id', 'realized_on', 'realised_by_id'],
            OptPaymentReconsile::SCENARIO_MIGRATE => $migScen
        ];
    }

    public function rules(): array {
        return [
            [["receipt_no", "deposited_bank", "deposited_by", "desposited_on", "status"], "required", 'when' => function ($model) {
                    return $model->type == 1;
                }],
            [["receipt_no", "realized_on", "realised_by", "status"], "required", 'when' => function ($model) {
                    return $model->type == 2;
                }],
            [["receipt_no", "deposited_bank", "deposited_by", "status", 'realised_by'], "string"],
            [["desposited_on"], 'date', 'format' => "yyyy-mm-dd"],
            ['deposited_by', function ($attribute, $params, $validator) {
                    $model = \common\models\User::find()->where(['OR', ['name' => $this->deposited_by], ['username' => $this->deposited_by]])->one();
                    if ($model instanceof \common\models\User) {
                        $this->deposited_by_id = $model->id;
                    } else {
                        $this->addError($attribute, "Invalid deposited by name/code.");
                    }
                }],
            ['realised_by', function ($attribute, $params, $validator) {
                    $model = \common\models\User::find()->where(['OR', ['name' => $this->realised_by], ['username' => $this->realised_by]])->one();
                    if ($model instanceof \common\models\User) {
                        $this->realised_by_id = $model->id;
                    } else {
                        $this->addError($attribute, "Invalid deposited by name/code.");
                    }
                }],
            ["receipt_no", function ($attribute, $params, $validator) {
                    $model = OptPaymentReconsile::findOne(['receipt_no' => $this->receipt_no]);
                    if ($model instanceof OptPaymentReconsile) {
                        $this->id = $model->id;
                        if ($this->type == 1 && in_array($model->status, [C::RECONSILE_STATUS_PENDING])) {
                            $this->addError($attribute, "Cannot Deposit as it is already " . $model->status_label);
                        }
                        if ($this->type == 2 && in_array($model->status, [C::RECONSILE_STATUS_DEPOSITED])) {
                            $this->addError($attribute, "Cannot Reconciled as it is already " . $model->status_label);
                        }
                    } else {
                        $this->addError($attribute, "Invalid receipt no.");
                    }
                }],
            ["status", function ($attribute, $params, $validator) {
                    $lbl = array_flip(C::LABEL_RECONSILE_STATUS);
                    if (!empty($lbl[ucwords($this->status)])) {
                        $this->status_int = $lbl[ucwords($this->status)];
                    } else {
                        $this->addError($attribute, "Invalid status specified. Status can have value " . implode(",", C::LABEL_RECONSILE_STATUS));
                    }
                }]
        ];
    }

    public function save() {
        if (!$this->hasErrors()) {
            $model = OptPaymentReconsile::findOne(['receipt_no' => $this->receipt_no]);
            if ($model instanceof OptPaymentReconsile) {
                if (in_array($model->status, [C::RECONSILE_STATUS_PENDING, C::RECONSILE_STATUS_DEPOSITED])) {
                    $model->scenario = OptPaymentReconsile::SCENARIO_UPDATE;

                    if ($this->type == 1) {
                        $model->deposited_bank = $this->deposited_bank;
                        $model->deposited_by = $this->deposited_by_id;
                        $model->desposited_on = $this->desposited_on;
                    } else {
                        $model->realised_by = $this->realised_by_id;
                        $model->realized_on = $this->realized_on;
                    }
                    $model->status = $this->status_int;
                    if ($model->validate() && $model->save()) {
                        print_r($model->attributes);
                        $this->successCnt++;
                        $this->response[$this->count]['message'] = "Ok";
                        return true;
                    } else {
                        $this->errorCnt++;
                        $this->response[$this->count]["message"] = implode(" ", $model->getErrorSummary(true));
                    }
                } else {
                    $txt = "";
                    if ($this->status_int == C::RECONSILE_STATUS_BOUNCE) {
                        $txt = "Already marked as bounce";
                    } else if ($this->status_int == C::RECONSILE_STATUS_CANCELLED) {
                        $txt = "Already marked as cancelled";
                    }
                    $this->errorCnt++;
                    $this->response[$this->count]["message"] = $txt;
                }
            }
        } else {
            $this->errorCnt++;
            $this->response[$this->count]["message"] = implode(" ", $this->getErrorSummary(true));
        }
        return false;
    }

    //put your code here
    public function _execute($data) {
        $this->scenario = OptPaymentReconsile::SCENARIO_MIGRATE;

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
