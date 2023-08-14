<?php

namespace common\forms;

use common\models\CustomerAccount;
use common\models\CustomerAccountBouquet;
use common\ebl\Constants as C;
use common\component\Utils as U;
use common\models\CustomerWallet;

class RenewAccount extends \yii\base\Model {

    const SCENARIO_RENEW = "renew";

    public $account_id;
    public $operator_id;
    public $bouquet_id;
    public $addon_ids;
    public $remark;
    public $voucher_code;
    public $rates;
    public $amount;
    public $mode;
    public $instrument_nos;
    public $instrument_date;
    public $account;
    public $start_date;
    public $end_date;
    public $trans_grp;
    public $message;

    public function scenarios() {
        return [
            self::SCENARIO_RENEW => ["account_id", "operator_id", "bouquet_id", "addon_ids", "voucher_code", "instrument_date", "instrument_nos", "amount", "mode"]
        ];
    }

    public function attributeLabels(): array {
        return [
            "bouquet_id" => "Bouquet",
            "addon_ids" => "Addons",
        ];
    }

    public function rules(): array {
        return [
            [["account_id", "bouquet_id"], "required"],
            [['amount'], 'number'],
            [['chequeno', "mode", "trans_grp", "remark", "voucher_code", "instrument_date", "instrument_nos", "mode"], "string"],
            [["account_id", "bouquet_id"], "integer"],
            ["account_id", function () {
                    $account = CustomerAccount::findOne(['id' => $this->account_id]);
                    if (!$account instanceof CustomerAccount) {
                        $this->addError("account_id", "Invalid Account details provided.");
                    } else {
                        $this->account = $account;
                    }
                }],
            ['voucher_code', function () {
                    $vc = \common\models\VoucherMaster::findOne(['id' => $this->voucher_code, 'operator_id' => $this->operator_id, 'status' => C::VOUCHER_ACTIVE]);
                    if (!$vc instanceof \common\models\VoucherMaster) {
                        $this->addError('voucher_code', 'Voucher is not applicable.');
                    } else {
                        \common\models\VoucherMaster::updateAll(['is_locked' => strtotime('now')], ['id' => $vc->id]);
                    }
                }],
        ];
    }

    public function afterValidate() {
        echo "<pre>";
        if (!empty($this->bouquet_id) && $this->account instanceof CustomerAccount) {

            $this->rates = new \common\ebl\RateCalculation([
                "account_id" => $this->account_id,
                'operator_id' => $this->operator_id,
                'bouquet_id' => \yii\helpers\ArrayHelper::merge([$this->bouquet_id], !empty($this->addon_ids) ? $this->addon_ids : []),
                "voucher_code" => $this->voucher_code
            ]);

            $r = $this->rates->getRateDetails();
            if (empty($r)) {
                $this->addError("bouquet_id", "Rates not defined or bouquets not assigned to Franchise");
                return false;
            } else {
                $operator = \common\models\Operator::findOne(['id' => $this->account->operator_id]);
                if (!$operator->isBalanceAvailable($r['total_amount'] + $r['total_tax'])) {
                    $this->addError("operator_id", "Insufficient balance in Franchise account.");
                    return false;
                }
            }
        }
        return parent::afterValidate();
    }

    public function save() {
        if (!$this->hasErrors()) {
            $this->trans_grp = uniqid() . time();
            $rates = $this->rates->getRateDetails();
           
            if (!empty($rates['b'])) {
                $this->account->scenario = CustomerAccount::SCENARIO_UPDATE;
                $this->account->start_date = ($this->account->status != C::STATUS_ACTIVE) ? $rates['start_date'] : $this->account->start_date;
                $this->account->end_date = $rates['display_date'];
                $this->account->status = C::STATUS_ACTIVE;
                if ($this->account->validate() && $this->account->save()) {
                    $plans = [];
                    if (!empty($this->bouquet_id)) {
                        $plans = $this->addPlans($this->account);
                    }
                    if (!empty($this->amount)) {
                        $this->makePayment($this->account, $plans);
                    }
                    return $this->account;
                }
            }
        }

        return false;
    }

    public function addPlans($account) {
        $pl_id = [];
        if ($this->rates instanceof \common\ebl\RateCalculation) {
            $rates = $this->rates->getRateDetails();
            foreach ($rates['b'] as $d) {
                $model = new CustomerAccountBouquet(['scenario' => CustomerAccountBouquet::SCENARIO_CREATE]);
                $model->account_id = $account->id;
                $model->customer_id = $account->customer_id;
                $model->operator_id = $account->operator_id;
                $model->road_id = $account->road_id;
                $model->building_id = $account->building_id;
                $model->router_type = $account->router_type;
                $model->start_date = $d['start_date'];
                $model->end_date = $d['display_date'];
                $model->cal_end_date = $d['end_date'];
                $model->status = $d['status'];
                $model->bouquet_id = $d['bouquet_id'];
                $model->bouquet_type = $d['bouqet_type'];
                $model->is_refundable = $d['is_refundable'];
                $model->meta_data = ["debit" => $d];
                $model->rate_id = $d['rate_id'];
                $model->per_day_amount = $d['per_day_amount'];
                $model->per_day_mrp = $d['per_day_mrp'];
                $model->amount = $d['amount'];
                $model->tax = U::calculateTax($model->amount);
                $model->mrp = $d['mrp'];
                $model->mrp_tax = U::calculateTax($model->mrp);
                $model->voucher_amount = $d['cust_amount'];
                $model->voucher_tax = 0;
                $model->bouquet_name = $d['bouquet_name'];
                $model->voucher_id = $d['voucher_id'];
                $total_amount = $model->amount + $model->tax;
                $total_mrp = $model->mrp + $model->mrp_tax;
                $model->trans_grp = $this->trans_grp;
                $this->message .= $model->remark = "Bouquet  " . $d['bouquet_name'] . " renewed on username {$account->username} "
                        . "from {$model->start_date} & {$model->end_date} and charged amount {$total_amount} and mrp {$total_mrp}.";
                $model->renewal_type = C::RENEWAL_TYPE_FRESH;
                $model->tax = U::calculateTax($model->amount);
                if ($model->validate() && $model->save()) {
                    $pl_id[] = [
                        "bouquet_name" => $d["bouquet_name"],
                        "bouquet_type" => $d['bouqet_type'],
                        "start_date" => $model->start_date,
                        "end_date" => $model->end_date,
                        "id" => $model->id,
                        "mrp" => $model->mrp,
                        "mrp_tax" => $model->mrp_tax,
                    ];
                }
            }
        }
        return $pl_id;
    }

    public function makePayment($account, $plans) {
        $model = new CustomerWallet(['scenario' => CustomerWallet::SCENARIO_CREATE]);
        $model->subscriber_id = $account->customer_id;
        $model->account_id = $account->id;
        $model->operator_id = $account->operator_id;
        $model->trans_type = C::TRANS_CR_SUBSCRIBER_PAYMENT;
        $model->amount = $this->amount;
        $model->tax = 0;
        $model->trans_grp = $this->trans_grp;
        $this->message .= $model->remark = "Received amount of " . CURRENCY . "{$model->amount}  " . C::TRANS_LABEL[C::TRANS_CR_SUBSCRIBER_PAYMENT];
        $meta_data = [
            "bouquet" => $plans,
            "instrument_date" => $this->instrument_date,
            "instrument_nos" => $this->instrument_nos,
            "instrument_name" => C::LABEL_PAY_MODE[$this->mode],
        ];

        $model->meta_data = $meta_data;
        if ($model->validate() && $model->save()) {
            return true;
        }
        return false;
    }

}
