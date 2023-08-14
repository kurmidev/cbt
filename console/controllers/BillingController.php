<?php

namespace console\controllers;

use common\ebl\Constants as C;
use common\models\Operator;
use common\models\OperatorWallet;
use common\models\OperatorBill;
use common\models\OperatorBillDetails;
use common\models\CustomerAccountBouquet;
use common\models\CustomerAccount;
use common\models\CustomerBill;
use common\models\CustomerWallet;
use common\component\Utils as U;

class BillingController extends BaseConsoleController {

    public $bill_month;
    public $bill_start_date;
    public $bill_end_date;

    public function init() {
        parent::init();
    }

    public function getMonth() {
        $this->bill_start_date = date("Y-m-1", strtotime($this->bill_month));
        $this->bill_end_date = date("Y-m-t", strtotime($this->bill_month));
    }

    public function actionOperatorBill($bill_month = "", $operator_ids = []) {
        $this->bill_month = !empty($bill_month) ? $bill_month : date("Y-m-01");
        $this->getMonth();
        $operatorQuery = Operator::find()->alias("a")->excludeSysDef()->joinWith(['wallets w'])->distinct()
                ->andWhere(['between', 'w.added_on', $this->bill_start_date, $this->bill_end_date])
                ->andFilterWhere(["a.id" => $operator_ids])
                ->indexBy("id");
        $count = $operatorQuery->count();
        $i = 1;
        foreach ($operatorQuery->batch() as $operator) {
            foreach ($operator as $operator_id => $opData) {
                $model = OperatorBill::findOne(['operator_id' => $operator_id, 'bill_month' => $this->bill_month]);
                if (!$model instanceof OperatorBill) {
                    $model = new OperatorBill();
                    $model->operator_id = $operator_id;
                    $model->distributor_id = $opData->distributor_id;
                    $model->bill_month = $this->bill_month;
                    $model->start_date = $this->bill_start_date;
                    $model->end_date = $this->bill_end_date;
                }
                $model->opening_amount = !empty($opData->lastBill) ? $opData->lastBill->closing_amount : 0;
                list($sel, $cond) = U::getCharges();
                $charges = \common\models\OperatorWallet::find()->where(['operator_id' => $operator_id, "trans_type" => $cond])
                                ->andWhere(['between', 'added_on', $this->bill_start_date, $this->bill_end_date])
                                ->select($sel)->asArray()->one();
                $model->payment = $charges['payment_amount'];
                $model->plan_charges = [
                    "amount" => $charges['plans_amount'],
                    "tax" => $charges['plans_tax'],
                ];
                $model->debit_charges = [
                    "amount" => $charges['debit_amount'],
                    "tax" => $charges['debit_tax'],
                ];
                $model->credit_charges = [
                    "amount" => $charges['credit_amount'],
                    "tax" => $charges['credit_tax'],
                ];

                $model->debit_charges_nt = $charges['debit_nt_amount'];
                $model->credit_charges_nt = $charges['credit_nt_amount'];
                $model->hardware_charges = 0;
                $model->sub_amount = $model->plan_charges['amount'] + $model->debit_charges['amount'] + $model->credit_charges['amount'];
                $model->sub_amount_tax = $model->plan_charges['tax'] + $model->debit_charges['tax'] + $model->credit_charges['tax'];
                $model->total = $model->sub_amount + $model->sub_amount_tax + $model->debit_charges_nt + $model->hardware_charges + $model->credit_charges_nt + $model->payment;
                $model->closing_amount = $model->total - $model->opening_amount;

                if ($model->validate() && $model->save()) {
                    $this->addBillDetails($model);
                    $this->addSubscriptionData($model);
                    echo "Operator Id {$model->operator_id} bill generated. total {$i}/{$count}" . PHP_EOL;
                } else {
                    print_r($model->errors);
                }
                $i++;
            }
        }
    }

    public function getCharges($operator_id, $is_operator = 1) {
        $charge_list = $is_operator == 1 ? $this->charge_list : $this->customer_charge_list;
        $result = [];
        $sel = $cond = [];
        foreach ($charge_list as $charge_name => $charge_items) {
            $sub_query = " sum(";
            $sub_query .= "case  when ";
            $sub_query .= ($charge_items['is_tax']) ? " tax>0 and " : " tax=0 and ";
            if (!empty($charge_items['credit'])) {
                $sub_query .= " trans_type in (" . implode(",", $charge_items['credit']) . ")  then 1 ";
            }
            if (!empty($charge_items['credit']) && !empty($charge_items['debit'])) {
                $sub_query .= " when   ";
            }
            if (!empty($charge_items['debit'])) {
                $sub_query .= "  trans_type in (" . implode(",", $charge_items['debit']) . ") then -1 ";
            }

            $sel[] = $sub_query . "  else 0 end * amount)  as {$charge_name}_amount";
            if ($charge_items['is_tax']) {
                $sel[] = $sub_query . " else 0 end * tax  )    as {$charge_name}_tax";
            }

            $cond = array_merge($cond, $charge_items['credit'], $charge_items['debit']);
        }

        if ($is_operator) {
            $model = OperatorWallet::find()->where(['operator_id' => $operator_id, "trans_type" => $cond])
                    ->andWhere(['between', 'added_on', $this->bill_start_date, $this->bill_end_date])
                    ->select($sel);
        } else {
            $model = CustomerWallet::find()->where(['account_id' => $operator_id, "trans_type" => $cond])
                    ->andWhere(['between', 'added_on', $this->bill_start_date, $this->bill_end_date])
                    ->select($sel);
        }
//        echo PHP_EOL;
//        print_r($model->rawSql);
//        echo PHP_EOL;
        return $model->asArray()->one();
    }

    public function addBillDetails(OperatorBill $bill) {
        $condition = new \yii\db\Query();
        $condition->where(['not', ['trans_type' => [C::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES, C::TRANS_DR_SUBSCRIPTION_CHARGES]]])
                ->andWhere(['bill_id' => $bill->id]);
        OperatorBillDetails::deleteAll($condition->where);

        $opwal = OperatorWallet::find()->where(['operator_id' => $bill->operator_id])
                ->andWhere(['not', ['trans_type' => [C::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES, C::TRANS_DR_SUBSCRIPTION_CHARGES]]])
                ->andWhere(['between', 'added_on', date("Y-m-d 00:00:00", strtotime($bill->start_date)), date("Y-m-d 23:59:00", strtotime($bill->end_date))])
                ->select(['operator_id', "counts" => "count(id)", "trans_type", "rate" => "amount", "amount" => "sum(amount)", "tax" => "sum(tax)"])
                ->groupBy(['operator_id', "amount", "trans_type"]);

        foreach ($opwal->batch() as $op) {
            foreach ($op as $opdata) {
                $model = OperatorBillDetails::findOne(['operator_id' => $bill->operator_id, "bill_month" => $bill->bill_month, "trans_type" => $opdata->trans_type]);
                if (!$model instanceof OperatorBillDetails) {
                    $model = new OperatorBillDetails();
                    $model->bill_id = $bill->id;
                    $model->operator_id = $bill->operator_id;
                    $model->distributor_id = $bill->distributor_id;
                    $model->bill_no = $bill->bill_no;
                    $model->bill_month = $bill->bill_month;
                    $model->bill_start_date = $bill->start_date;
                    $model->bill_end_date = $bill->end_date;
                    $model->trans_type = $opdata->trans_type;
                    $model->trans_type_name = C::TRANS_LABEL[$opdata->trans_type];
                    $model->counts = $opdata->counts;
                    $model->per_day_rate = $opdata->rate;
                    $model->amount = $opdata->amount;
                    $model->tax = $opdata->tax;
                    if ($model->validate()) {
                        $model->save();
                    } else {
                        print_r($model->errors);
                    }
                }
            }
        }
    }

    public function addSubscriptionData(OperatorBill $bill) {
        $condition = new \yii\db\Query();
        $condition->where(['trans_type' => [C::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES, C::TRANS_DR_SUBSCRIPTION_CHARGES], 'bill_id' => $bill->id]);

        OperatorBillDetails::deleteAll($condition->where);

        $query = OperatorWallet::find()->alias("a")->where(['a.operator_id' => $bill->operator_id])
                ->joinWith(['CustomerWallet b'])
                ->andWhere(['a.trans_type' => [C::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES, C::TRANS_DR_SUBSCRIPTION_CHARGES]])
                ->andWhere(['between', 'a.added_on', date("Y-m-d 00:00:00", strtotime($bill->start_date)), date("Y-m-d 23:59:00", strtotime($bill->end_date))])
                ->select(['a.operator_id', "b.plan_id", "counts" => new \yii\db\Expression("DATEDIFF(b.start_date,b.end_date)"), "a.trans_type", "rate" => "a.amount", "amount" => "sum(a.amount)", "tax" => "sum(a.tax)"])
                ->groupBy(['a.operator_id', "a.amount", "a.trans_type", "b.plan_id", "counts"]);

        foreach ($query->batch() as $products) {
            foreach ($products as $product) {
                $model = OperatorBillDetails::findOne(['operator_id' => $bill->operator_id, "bill_month" => $bill->bill_month, "trans_type" => $product->trans_type]);
                if (!$model instanceof OperatorBillDetails) {
                    $model = new OperatorBillDetails();
                    $model->bill_id = $bill->id;
                    $model->operator_id = $bill->operator_id;
                    $model->distributor_id = $bill->distributor_id;
                    $model->bill_no = $bill->bill_no;
                    $model->bill_month = $bill->bill_month;
                    $model->bill_start_date = $bill->start_date;
                    $model->bill_end_date = $bill->end_date;
                    $model->trans_type = $product->trans_type;
                    $model->trans_type_name = C::TRANS_LABEL[$product->trans_type];
                    $model->counts = $product->counts;
                    $model->per_day_rate = $product->rate / $product->counts;
                    $model->amount = $product->amount;
                    $model->tax = $product->tax;
                    if ($model->validate()) {
                        $model->save();
                    }
                }
            }
        }
    }

    public function actionCustomerBill($bill_month = "", $operator_ids = [], $account_id = []) {
        $this->bill_month = !empty($bill_month) ? $bill_month : date("Y-m-01");
        $this->getMonth();

        $accountQuery = CustomerAccount::find()->alias('a')->distinct()
                        ->innerJoinWith(["CustomerWallet w"])
                        ->andWhere(['is not ', 'w.id', null])
                        ->andWhere(['between', 'a.added_on', $this->bill_start_date, $this->bill_end_date])
                        ->andFilterWhere(['a.operator_id' => $operator_ids])->andFilterWhere(['a.id' => $account_id]);

        print_r($accountQuery->getRawSql());
        $count = $accountQuery->count();
        echo "Total Bills to generate {$count}" . PHP_EOL;
        $i = 1;
        foreach ($accountQuery->batch() as $accounts) {
            foreach ($accounts as $account) {
                $model = CustomerBill::findOne(['account_id' => $account->id, 'bill_month' => $this->bill_month]);
                if (!$model instanceof CustomerBill) {
                    $model = new CustomerBill(['scenario' => CustomerBill::SCENARIO_CREATE]);
                    $model->customer_id = $account->customer_id;
                    $model->account_id = $account->id;
                    $model->operator_id = $account->operator_id;
                    $model->bill_month = $this->bill_month;
                    $model->bill_start_date = $this->bill_start_date;
                    $model->bill_end_date = $this->bill_end_date;
                }
                $model->opening = !empty($account->lastBill) ? $account->lastBill->closing : 0;
                list($sel, $cond) = U::getCharges(0);
                $charges = \common\models\CustomerWallet::find()->where(['account_id' => $account_id, "trans_type" => $cond])
                                ->andWhere(['between', 'added_on', $this->bill_start_date, $this->bill_end_date])
                                ->select($sel)->asArray()->one();
                $model->payment = $charges['payment_amount'];
                $model->subscription_charges = [
                    "amount" => !empty($charges['plans_amount']) ? $charges['plans_amount'] : 0,
                    "tax" => !empty($charges['plans_tax']) ? $charges['plans_tax'] : 0,
                ];
                $model->debit_charges = [
                    "amount" => !empty($charges['debit_amount']) ? $charges['debit_amount'] : 0,
                    "tax" => !empty($charges['debit_tax']) ? $charges['debit_tax'] : 0,
                ];
                $model->credit_charges = [
                    "amount" => !empty($charges['credit_amount']) ? $charges['credit_amount'] : 0,
                    "tax" => !empty($charges['credit_tax']) ? $charges['credit_tax'] : 0,
                ];

                $model->debit_charges_nt = !empty($charges['debit_nt_amount']) ? $charges['debit_nt_amount'] : 0;
                $model->credit_charges_nt = !empty($charges['credit_nt_amount']) ? $charges['credit_nt_amount'] : 0;
                $model->hardware_charges = 0;
                $model->sub_amount = $model->subscription_charges['amount'] + $model->debit_charges['amount'] + $model->credit_charges['amount'];
                $model->sub_tax = $model->subscription_charges['tax'] + $model->debit_charges['tax'] + $model->credit_charges['tax'];
                $model->total = $model->sub_amount + $model->sub_tax + $model->debit_charges_nt + $model->hardware_charges + $model->credit_charges_nt + $model->payment;
                $model->closing = $model->total - $model->opening;

                if ($model->validate() && $model->save()) {
                    echo "Account {$account->cid} bill generated. total {$i}/{$count}" . PHP_EOL;
                }
                $i++;
            }
        }
    }

    public function actionTest() {
        $bill = OperatorBill::findOne(["id" => 1]);
        if ($bill instanceof OperatorBill) {
            $this->addSubscriptionData($bill);
        }
    }

}
