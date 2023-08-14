<?php

namespace common\forms;

use common\models\Operator;
use common\ebl\Constants as C;
use common\models\OperatorWallet;
use common\component\Utils as U;

class CreditDebit extends \yii\base\Model {

    public $type;
    public $amount;
    public $is_taxable;
    public $instrument_nos;
    public $instrument_date;
    public $remark;
    public $operator_id;
    public $tax;
    public $name;
    public $msg;

    public function rules() {
        return [
            [['type', 'amount', 'is_taxable', 'instrument_nos', 'instrument_date', 'remark'], 'required'],
            ['type', 'in', 'range' => array_keys(C::PARTICULAR_LABEL)],
            ['remark', 'string', 'max' => 250],
            [['is_taxable'], 'integer'],
            [['amount', 'tax'], 'number'],
            [['instrument_nos'], 'safe']
        ];
    }

    public function attributeLabels() {
        return [
            "amount" => "Amount",
            "is_taxable" => "Is Taxable",
            "type" => "Note Type",
            "instrument_nos" => "Particular",
            "instrument_date" => "Date",
            "remark" => "Remark"
        ];
    }

    public function getData() {
        $data = [];
        $model = OperatorWallet::findOne(['id' => $this->instrument_nos]);
        if ($model instanceof OperatorWallet) {
            $data = [
                "receipt_no" => $model->receipt_no,
                "amount" => $model->amount,
                "tax" => $model->tax,
            ];
            $data = \yii\helpers\ArrayHelper::merge($data, $model->meta_data);
        }

        return $data;
    }

    public function save() {
        if (!$this->hasErrors()) {

            $model = new OperatorWallet(['scenario' => OperatorWallet::SCENARIO_CREATE]);
            $model->cr_operator_id = ($this->type == C::PARTICULAR_TYPE_CREDIT) ? $this->operator_id : NULL;
            $model->dr_operator_id = ($this->type == C::PARTICULAR_TYPE_DEBIT) ? $this->operator_id : NULL;
            $model->operator_id = $this->operator_id;
            $model->amount = $this->amount;
            $this->tax = $model->tax = $this->is_taxable ? U::calculateTax($this->amount) : 0;
            $model->transaction_id = null;
            $model->trans_type = ($this->type == C::PARTICULAR_TYPE_CREDIT) ? C::TRANS_CR_OPERATOR_CREDIT_NOTE : C::TRANS_DR_OPERATOR_DEBIT_NOTE;
            $model->remark = $this->remark;
            $model->meta_data = $this->getData();
            if ($model->validate() && $model->save()) {
                $lbl = ($this->type == C::PARTICULAR_TYPE_CREDIT) ? "Credit" : "Debit";
                $amount = $model->amount + $model->tax;
                $this->msg = "$lbl raised against " . $model->meta_data['receipt_no'] . " with amount of Rs " . $amount;
                return $model;
            } else {
                $this->addError($model->errors);
                return false;
            }
        }
        return FALSE;
    }

}
