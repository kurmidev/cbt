<?php

namespace common\ebl;

use common\models\OperatorRates;
use common\models\CustomerAccount;
use common\models\RateMaster;
use common\component\Utils as U;
use common\ebl\Constants as C;
use common\models\PlanMaster;
use common\models\StaticipPolicy;
use yii\helpers\ArrayHelper;

/**
 * Description of RateCalculation
 *
 * @author chandrap
 */
class RateCalculation extends \yii\base\Model {

    public $operator_id;
    public $account_id;
    public $start_date;
    public $end_date;
    public $type;
    public $bouquet_id;
    public $voucher_code;
    public $account;

    const ACTION_TYPE_RENEW = 1;
    const ACTION_TYPE_ADDON = 2;
    const ACTION_TYPE_REMOVE = 3;

    public function __construct($config = []) {
        parent::__construct($config);
        $this->_setAccount();
    }

    private function _setAccount() {
        $account = CustomerAccount::findOne(['id' => $this->account_id]);
        if ($account instanceof CustomerAccount) {
            $this->account = $account;
            $this->operator_id = $account->operator_id;
            $bg = OperatorRates::find()->alias("a")
                            ->where(['a.operator_id' => $this->account->operator_id, 'a.id' => $this->bouquet_id])
                            ->joinWith(['bouquet b'])->asArray()->all();
            if (!empty($bg)) {
                $r = ArrayHelper::getColumn($bg, "bouquet.type");
                if (in_array(C::PLAN_TYPE_BASE, $r)) {
                    $this->start_date = U::addDays($this->account->end_date, 1);
                } else if ($this->account->status == C::STATUS_ACTIVE) {
                    $this->start_date = date("Y-m-d");
                    $this->end_date = $account->end_date;
                }
            }
        }
    }

    public function getVoucherDetails() {
        if (!empty($this->voucher_code)) {
            $vc = \common\models\VoucherMaster::find()
                            ->where(['id' => $this->voucher_code, 'operator_id' => $this->operator_id, 'status' => C::VOUCHER_ACTIVE])
                            ->andWhere(['OR', ['>', 'is_locked', strtotime("-3 minutes")], ['is_locked' => 0]])->one();
            if ($vc instanceof \common\models\VoucherMaster) {
                if ($vc->is_locked == 0) {
                    \common\models\VoucherMaster::updateAll(['is_locked' => strtotime("now")], ['id' => $vc->id]);
                }
                return [
                    "voucher_id" => $vc->id,
                    "opt_amount" => $vc->opt_amount,
                    "cust_amount" => $vc->cust_amount,
                    "bouquet_id" => $vc->bouquet_id
                ];
            }
        }

        return [
            "voucher_id" => 0,
            "opt_amount" => 0,
            "cust_amount" => 0,
            "bouquet_id" => 0
        ];
    }

    public function getRateDetails() {
        $rates = [];
        $bouquets = OperatorRates::find()
                ->where(['operator_id' => $this->operator_id, 'id' => $this->bouquet_id])
                ->all();

        if (!empty($bouquets)) {
            $t_amount = $t_tax = $t_mrp = $t_mrp_tax = 0;
            $rates = ["b" => [], "total_amount" => 0, "total_tax" => 0, "total_mrp" => 0, "total_mrp_tax" => 0, "start_date" => "", "end_date" => "", "display_date" => "", "amount_total" => 0, "mrp_total" => 0];
            foreach ($bouquets as $bouquet) {
                $this->start_date = !empty($this->start_date) ? $this->start_date : date("Y-m-d");
                $this->end_date = !empty($this->end_date) ? $this->end_date :
                        U::addDays($this->start_date, $bouquet->bouquet->days);
                $displayDates = !empty($bouquet->bouquet->free_days) ?
                        U::addDays($this->end_date, $bouquet->bouquet->free_days) : $this->end_date;
                $planDays = $bouquet->bouquet->days;
                $plan_amount = $bouquet->amount;
                $plan_mrp = $bouquet->mrp;
                $voucher = $this->getVoucherDetails();
                if (!empty($voucher['opt_amount']) && $voucher['bouquet_id'] == $bouquet->assoc_id) {
                    $plan_amount = $plan_amount > $voucher['opt_amount'] ? $plan_amount - $voucher['opt_amount'] : $plan_amount;
                }

                if (!empty($voucher['cust_amount'])) {
                    $plan_mrp = $plan_mrp > $voucher['cust_amount'] ? $plan_mrp - $voucher['cust_amount'] : $plan_mrp;
                }

                $totalDays = U::dateDiff($this->start_date, $this->end_date);
                $perDayAmount = $plan_amount / $planDays;
                $perDayMrp = $plan_mrp / $planDays;
                $amount = $perDayAmount * $totalDays;
                $tax = U::calculateTax($amount);
                $mrp = $perDayMrp * $totalDays;
                $mrp_tax = U::calculateTax($mrp);
                $t_mrp_tax += $mrp_tax;
                $t_mrp += $mrp;
                $t_amount += $amount;
                $t_tax += $tax;

                $commonData = [
                    "rate_id" => $bouquet->id,
                    "actual_bouquet_amount" => $bouquet->amount,
                    "actual_bouquet_mrp" => $bouquet->mrp,
                    "per_day_amount" => $perDayAmount,
                    "per_day_mrp" => $perDayMrp,
                    "start_date" => $this->start_date,
                    "end_date" => $this->end_date,
                    'display_date' => $displayDates,
                    'total_days' => U::dateDiff($this->start_date, $this->end_date),
                    "status" => strtotime($this->end_date) > strtotime(date("Y-m-d")) ? C::STATUS_ACTIVE : C::STATUS_EXPIRED,
                    "is_refundable" => 1,
                    "voucher_id" => ($voucher['bouquet_id'] == $bouquet->assoc_id) ? $voucher['voucher_id'] : 0,
                    "opt_amount" => ($voucher['bouquet_id'] == $bouquet->assoc_id) ? $voucher['opt_amount'] : 0,
                    "cust_amount" => ($voucher['bouquet_id'] == $bouquet->assoc_id) ? $voucher['cust_amount'] : 0
                ];

                $r["bouquet_name"] = $bouquet->bouquet->name;
                $r["bouquet_id"] = $bouquet->assoc_id;
                $r["bouqet_type"] = $bouquet->bouquet->type;
                $r["amount"] = $amount;
                $r["tax"] = $tax;
                $r["total"] = ($amount + $tax);
                $r["mrp"] = $mrp;
                $r["mrp_tax"] = $mrp_tax;
                $r["mrp_total"] = ($mrp + $mrp_tax);
                $rates['b'] = ArrayHelper::merge($rates['b'], [$bouquet->assoc_id => ArrayHelper::merge($r, $commonData)]);
                $rates["total_amount"] = $t_amount;
                $rates["total_tax"] = $t_tax;
                $rates["total_mrp"] = $t_mrp;
                $rates["total_mrp_tax"] = $t_mrp_tax;
                $rates["amount_total"] = $t_amount + $t_tax;
                $rates["mrp_total"] = $t_mrp_tax + $t_mrp;
                $rates['start_date'] = empty($rates['start_date']) ? $this->start_date : U::getMinDate($rates['start_date'], $this->start_date);
                $rates['end_date'] = empty($rates['end_date']) ? $this->end_date : U::getMinDate($rates['end_date'], $this->end_date);
                $rates['display_date'] = empty($rates['display_date']) ? $displayDates : U::getMinDate($rates['display_date'], $display_date);
            }
        }
        return $rates;
    }

}

class RateCalculationOld extends \yii\base\Model {

    public $assoc_id;
    public $operator_id;
    public $account_id;
    public $type;
    public $start_date;
    public $end_date;
    public $account;
    public $action_type;
    public $rate_id;
    public $plan;
    public $voucher_code;

    const ACTION_TYPE_RENEW = 1;
    const ACTION_TYPE_ADDON = 2;
    const ACTION_TYPE_REMOVE = 3;

    public function __construct($config = array()) {
        parent::__construct($config);
        if (!empty($this->account_id)) {
            $this->_setAccount();
            $this->_setPlan();
        }
    }

    private function _setPlan() {
        if (!empty($this->assoc_id) && $this->type == C::RATE_TYPE_BOUQUET) {
            $this->plan = \common\models\Bouquet::findOne(['id' => $this->assoc_id]);
        } else if (!empty($this->assoc_id) && $this->type == C::RATE_TYPE_STATICIP) {
            $this->plan = StaticipPolicy::findOne(['id' => $this->assoc_id]);
        }
    }

    private function _setAccount() {
        $this->start_date = !empty($this->start_date) ? $this->start_date : date("Y-m-d");
        $account = CustomerAccount::findOne(['id' => $this->account_id]);
        if ($account instanceof CustomerAccount) {
            $this->account = $account;
            $this->operator_id = $account->operator_id;
            if (in_array($this->action_type, [self::ACTION_TYPE_RENEW])) {
                $this->start_date = ($account->status == C::STATUS_ACTIVE) ? U::addDays($account->end_date, 1) : date("Y-m-d");
            } else if (in_array($this->action_type, [self::ACTION_TYPE_ADDON])) {
                $this->start_date = date("Y-m-d");
                $this->end_date = $account->end_date;
            }
        }
    }

    public function getRates() {
        $rates = null;
        if (!empty($this->operator_id)) {
            $rates = OperatorRates::find()
                    ->joinWith(['bouquet'])
                    ->andWhere(['operator_id' => $this->operator_id,
                        'assoc_id' => $this->assoc_id, 'type' => $this->type])
                    ->andFilterWhere(['rate_id' => $this->rate_id]);
        } else {
            $rates = RateMaster::find()->joinWith(['bouquet'])->andWhere(['assoc_id' => $this->assoc_id, 'type' => $this->type])
                    ->andFilterWhere(['id' => $this->rate_id]);
        }

        return $rates->asArray()->all();
    }

    public function getVoucherDetails() {
        if (!empty($this->voucher_code)) {
            $vc = \common\models\VoucherMaster::find()
                            ->where(['id' => $this->voucher_code, 'operator_id' => $this->operator_id, 'status' => C::VOUCHER_ACTIVE])
                            ->andWhere(['OR', ['>', 'is_locked', strtotime("-3 minutes")], ['is_locked' => 0]])->one();
            if ($vc instanceof \common\models\VoucherMaster) {
                if ($vc->is_locked == 0) {
                    \common\models\VoucherMaster::updateAll(['is_locked' => strtotime("now")], ['id' => $vc->id]);
                }
                return [
                    "voucher_id" => $vc->id,
                    "opt_amount" => $vc->opt_amount,
                    "cust_amount" => $vc->cust_amount,
                    "bouquet_id" => $vc->bouquet_id
                ];
            }
        }

        return [
            "voucher_id" => 0,
            "opt_amount" => 0,
            "cust_amount" => 0,
            "bouquet_id" => 0
        ];
    }

    public function getCalculateRates() {
        $r = [];
        $rateList = $this->rates;
        $voucher_details = $this->getVoucherDetails();
        if (!empty($rateList)) {
            foreach ($rateList as $rate) {

                $this->start_date = !empty($this->start_date) ? $this->start_date : date("Y-m-d");
                $this->end_date = !empty($this->end_date) ? $this->end_date :
                        U::addDays($this->start_date, $rate['plan']['days']);
                $displayDates = !empty($rate['bouquet']['free_days']) ? U::addDays($this->end_date, $rate['bouquet']['free_days']) : $this->end_date;
                $planDays = $rate['bouquet']['days'];
                $plan_amount = $rate['amount'];
                $plan_mrp = $rate['mrp'];

                if (!empty($voucher_details['opt_amount'])) {
                    $plan_amount = $plan_amount > $voucher_details['opt_amount'] ? $plan_amount - $voucher_details['opt_amount'] : $plan_amount;
                }

                if (!empty($voucher_details['cust_amount'])) {
                    $plan_mrp = $plan_mrp > $voucher_details['cust_amount'] ? $plan_mrp - $voucher_details['cust_amount'] : $plan_mrp;
                }

                $totalDays = U::dateDiff($this->start_date, $this->end_date);
                $perDayAmount = $plan_amount / $planDays;
                $perDayMrp = $plan_mrp / $planDays;
                $amount = $perDayAmount * $totalDays;
                $tax = U::calculateTax($amount);
                $mrp = $perDayMrp * $totalDays;
                $mrp_tax = U::calculateTax($mrp);
                $d = [
                    "plan_name" => !empty($rate['plan']) ? $rate['plan']['name'] : "",
                    "plan_id" => !empty($rate['plan']) ? $rate['plan']['id'] : "",
                    "plan_type" => !empty($rate['plan']) ? $rate['plan']['plan_type'] : "",
                    "is_exclusive" => !empty($rate['plan']) ? $rate['plan']['is_exclusive'] : "",
                    "is_promotional" => !empty($rate['plan']) ? $rate['plan']['is_promotional'] : "",
                    "rate_id" => $rate['rate_id'],
                    "actual_plan_amount" => $rate['amount'],
                    "actual_plan_mrp" => $rate['mrp'],
                    "per_day_amount" => $perDayAmount,
                    "per_day_mrp" => $perDayMrp,
                    "amount" => $amount,
                    "tax" => $tax,
                    "total" => ($amount + $tax),
                    "mrp" => $mrp,
                    "mrp_tax" => $mrp_tax,
                    "mrp_total" => ($mrp + $mrp_tax),
                    "start_date" => $this->start_date,
                    "end_date" => $this->end_date,
                    'display_date' => $displayDates,
                    'total_days' => U::dateDiff($this->start_date, $this->end_date),
                    "status" => strtotime($this->end_date) > strtotime(date("Y-m-d")) ? C::STATUS_ACTIVE : C::STATUS_EXPIRED,
                    "is_refundable" => 1,
                    "voucher_id" => $voucher_details['voucher_id'],
                    "opt_amount" => $voucher_details['opt_amount'],
                    "cust_amount" => $voucher_details['cust_amount'],
                ];
                $r[$rate['bouquet']['id']] = $d;
            }
        }
        return $r;
    }

}
