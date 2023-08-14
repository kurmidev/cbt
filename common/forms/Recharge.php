<?php

namespace common\forms;

use common\models\Operator;
use common\models\OperatorWallet;
use common\ebl\Constants as C;

class Recharge extends \yii\base\Model {

    public $id;
    public $name;
    public $amount;
    public $balance;
    public $remark;
    public $mode;
    public $instrument_name;
    public $instrument_date;
    public $instrument_nos;
    public $pg_id;

    public function rules() {
        return [
            [['id', 'amount', 'remark', 'mode'], 'required'],
            ['mode', 'in', 'range' => array_keys(\common\ebl\Constants::LABEL_PAY_MODE)],
            [['instrument_name', 'instrument_date', 'instrument_nos'], 'required', 'when' => function () {
                    return !in_array($this->mode, [\common\ebl\Constants::PAY_MODE_CASH, \common\ebl\Constants::PAY_MODE_PAYMENT_GATEWAY]);
                }],
            ['remark', 'string', 'max' => 250],
            ['amount', 'number', 'min' => \Yii::$app->params['RECHAGE_MIN_AMOUNT']],
            [['pg_id'], 'required', 'when' => function () {
                    return $this->mode == C::PAY_MODE_PAYMENT_GATEWAY;
                }]
        ];
    }

    public function attributeLabels() {
        return [
            "name" => "Name",
            "amount" => "Amount",
            "balance" => "Balance",
            "remark" => "Remark",
            "mode" => "Payment Mode",
            "pg_id"=>'Payment Gateway'
        ];
    }

    public function save() {
        if (!$this->hasErrors()) {
            $model = new OperatorWallet(['scenario' => OperatorWallet::SCENARIO_CREATE]);
            $model->cr_operator_id = $this->id;
            $model->dr_operator_id = null;
            $model->operator_id = $this->id;
            $model->amount = $this->amount;
            $model->tax = 0;
            $model->transaction_id = null;
            $model->trans_type = C::TRANS_CR_OPERATOR_WALLET_RECHARGE;
            $model->remark = $this->remark;
            $model->meta_data = [
                'instrument_nos' => !empty($this->instrument_nos) ? $this->instrument_nos : "C" . time(),
                'instrument_date' => !empty($this->instrument_date) ? $this->instrument_date : date("Y-m-d"),
                'instrument_name' => !empty($this->instrument_name) ? $this->instrument_name : "CASH",
                'pay_mode' => $this->mode
            ];
            if ($model->validate() && $model->save()) {
                return $model;
            } else {
                $this->addError($model->errors);
                return false;
            }
        }
        return false;
    }

}
