<?php

namespace common\ebl\jobs;

use common\ebl\Constants as C;
use common\models\Operator;
use common\models\OperatorWallet;

class BulkWalletRechargeJob extends BaseJobs {

    public $operator_id;
    public $operator_code;
    public $operator_name;
    public $amount;
    public $remark;
    public $mode;
    public $instrument_name;
    public $instrument_date;
    public $instrument_nos;
    public $payment_mode;

    public function scenarios() {
        return [
            OperatorWallet::SCENARIO_CREATE => ["operator_id", "amount", "operator_code", "payment_mode", "remark", "mode", "instrument_name", "instrument_date", "instrument_nos"],
            OperatorWallet::SCENARIO_MIGRATE => ["operator_code", "amount", "remark", "payment_mode", "instrument_name", "instrument_date", "instrument_nos"],
        ];
    }

    public function rules() {
        return [
            [["amount", "payment_mode", "operator_code"], "required"],
            [["remark", "instrument_name", "instrument_date", "instrument_nos", "remark"], 'string'],
            [['operator_id', "mode"], 'integer'],
            ['amount', 'number', 'min' => \Yii::$app->params['RECHAGE_MIN_AMOUNT']],
            ["payment_mode", function ($attribute, $params, $validator) {
                    $rev = array_change_key_case(array_flip(C::LABEL_PAY_MODE), CASE_LOWER);
                    if (!empty($rev[strtolower($this->payment_mode)])) {
                        $this->mode = $rev[strtolower($this->payment_mode)];
                    } else {
                        $this->addError($attribute, "Invalid payment modes");
                    }
                }],
            ["operator_code", function ($attribute, $params, $validator) {
                    $model = Operator::find()->where(['or', ['name' => $this->operator_code], ['code' => $this->operator_code]])->one();
                    if ($model instanceof Operator) {
                        $this->operator_id = $model->id;
                        $this->operator_name = $model->name;
                    } else {
                        $this->addError($attribute, "Invalid LCO Code");
                    }
                }],
        ];
    }

    public function _execute($data) {
        $this->scenario = OperatorWallet::SCENARIO_CREATE;
        if ($this->load($data, '') && $this->validate() && $this->save()) {
            return true;
        } else {
            if (!empty($this->errors)) {
                $this->errorCnt++;
                $this->response[$this->count]["message"] = implode(" ", $this->getErrorSummary(true));
            }
        }
    }

    public function save() {
        if (!$this->hasErrors()) {
            $model = new \common\forms\Recharge();
            $model->id = $this->operator_id;
            $model->amount = $this->amount;
            $model->remark = $this->remark;
            $model->instrument_name = $this->instrument_name;
            $model->instrument_date = $this->instrument_date;
            $model->instrument_nos = $this->instrument_nos;
            $model->mode = $this->mode;
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

}
