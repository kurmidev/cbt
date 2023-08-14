<?php

namespace common\forms;

use common\ebl\Constants as C;
use common\models\OperatorRates;
use common\models\Operator;
use common\ebl\RateCalculation;
use common\models\RateMaster;
use common\models\Customer;
use common\models\CustomerAccount;
use common\models\CustomerAccountBouquet;
use common\models\OperatorWallet;
use common\models\CustomerWallet;
use common\component\Utils as U;
use common\models\User;

class AccountForm extends \yii\base\Model {

    const SCENARIO_RENEW = "renew";
    const SCENARIO_ADDONS = "addons";
    const SCENARIO_SUSPEND_RESUME = "suspend_resume";
    const SCENARIO_ACTIVATE_DEACTIVATE = "activate_deactivate";
    const SCENARIO_SETTINGS = "settings";
    const SCENARIO_TERMINATE = "terminate";
    const SCENARIO_PAYMENT = "payment";
    const SCENARIO_CHARGES = "charges";

    public $id;
    public $name;
    public $email;
    public $mobile_no;
    public $phone_no;
    public $gender;
    public $dob;
    public $connection_type;
    public $operator_id;
    public $area_id;
    public $road_id;
    public $building_id;
    public $nas_id;
    public $mac_address;
    public $static_ip;
    public $address;
    public $bill_address;
    public $is_auto_renew;
    public $status;
    public $bouquet_id;
    public $username;
    public $password;
    public $type;
    public $rperiod_id;
    public $macbinding_type;
    public $session_cnt;
    public $proof;
    public $rate_id;
    public $rates;
    public $prospect_id;
    public $charges;
    public $start_date;
    public $end_date;
    public $message;
    public $action_type;
    public $is_refund;
    public $remark;
    public $instrument_mode;
    public $instrument_date;
    public $instrument_nos;
    public $instrument_bank;
    public $amount;
    public $skip_balance_check = false;
    public $voucher_code;
    public $addon_ids;
    public $ip_details;
    public $device_details;

    public function scenarios() {
        return [
            Customer::SCENARIO_CREATE => ['name', 'username', 'password', 'mobile_no', 'phone_no', 'email', 'gender', 'dob', 'connection_type', 'operator_id', 'road_id', 'building_id', 'nas_id', 'activation_date', 'deactivation_date', 'address', 'bill_address', 'is_auto_renew', 'status', 'bouquet_id', 'macbinding_type', 'session_cnt', 'UploadedFile', 'rate_id', 'is_auto_renew', 'prospect_id', 'charges', 'area_id', 'voucher_code','addon_ids','ip_details','device_details'],
            self::SCENARIO_RENEW => ['bouquet_id', 'rperiod_id', 'id', 'start_date', 'end_date', 'voucher_code','addon_ids'],
            self::SCENARIO_ADDONS => ['bouquet_id', 'rperiod_id', 'id', 'start_date', 'end_date', 'voucher_code'],
            self::SCENARIO_SUSPEND_RESUME => ['status', 'is_refund', 'remark'],
            self::SCENARIO_SETTINGS => [],
            self::SCENARIO_TERMINATE => ['remark', 'id'],
            self::SCENARIO_PAYMENT => ['instrument_nos', 'instrument_date', 'instrument_mode', 'amount', 'remark', 'instrument_bank', 'id'],
            self::SCENARIO_CHARGES => ['amount', 'remark', 'type', 'id'],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Name',
            'username' => 'UserName',
            'password' => 'Password',
            'mobile_no' => 'Mobile No',
            'phone_no' => 'Phone No.',
            'email' => 'Email',
            'gender' => 'Gender',
            'dob' => 'DOB',
            'connection_type' => 'Connection Type',
            'operator_id' => 'Operator',
            'road_id' => 'Road',
            'building_id' => 'Building',
            'nas_id' => 'NAS',
            'activation_date' => 'Activation Date',
            'deactivation_date' => 'Deactivation Date',
            'address' => 'Address',
            'bill_address' => 'Bill Address',
            'is_auto_renew' => 'Auto Renew',
            'status' => 'Status',
            'bouquet_id' => 'Bouquet',
            'macbinding_type' => 'MAC-Binding Type',
            'session_cnt' => 'Session Count',
            'UploadedFile' => 'Upload File',
            'area_id' => 'Area',
            'voucher_code' => "Voucher/Coupons"
        ];
    }

    public function rules() {
        return [
            [['name', 'mobile_no', 'gender', 'connection_type', 'operator_id', 'building_id', 'bouquet_id', 'address', 'bill_address', 'is_auto_renew', 'username', 'password', 'type'], 'required'],
            [['name', 'mobile_no', 'address', 'bill_address', 'username', 'password', 'voucher_code'], 'string'],
            [['gender', 'connection_type', 'operator_id', 'building_id', 'nas_id', 'is_auto_renew', 'status', 'rate_id', 'is_auto_renew', 'prospect_id'], 'integer'],
            [['amount'], 'number'],
            [['instrument_date', 'instrument_bank'], 'required', 'when' => function () {
                    return $this->instrument_mode != C::PAY_MODE_CASH;
                }, 'on' => self::SCENARIO_PAYMENT],
            [['instrument_mode', 'remark'], 'required', 'on' => self::SCENARIO_PAYMENT],
            [['amount', 'type', 'remark'], 'required', 'on' => self::SCENARIO_CHARGES],
            ['voucher_code', function () {
                    $vc = \common\models\VoucherMaster::findOne(['id' => $this->voucher_code, 'operator_id' => $this->operator_id, 'status' => C::VOUCHER_ACTIVE]);
                    if (!$vc instanceof \common\models\VoucherMaster) {
                        $this->addError('voucher_code', 'Voucher is not applicable.');
                    } else {
                        \common\models\VoucherMaster::updateAll(['is_locked' => strtotime('now')], ['id' => $vc->id]);
                    }
                }, 'on' => [CustomerAccount::SCENARIO_CREATE, self::SCENARIO_RENEW, self::SCENARIO_ADDONS]],
            [['bouquet_id', 'rate_id'], function () {
                    if (!empty($this->rates)) {
                        return TRUE;
                    }
                    $op = OperatorRates::find()->where(['operator_id' => $this->operator_id, 'assoc_id' => $this->bouquet_id,
                                'type' => C::RATE_TYPE_BOUQUET,])->andFilterWhere(['rate_id' => $this->rate_id])->one();
                    if (!$op instanceof OperatorRates) {
                        $this->addError("bouquet_id", "Bouquet not assignd to operator.");
                    } else {
                        $rate = new RateCalculation([
                            'rate_id' => $this->rate_id,
                            'assoc_id' => $this->bouquet_id,
                            'type' => C::RATE_TYPE_BOUQUET,
                            'operator_id' => $this->operator_id,
                            'action_type' => $this->action_type,
                            "voucher_code" => $this->voucher_code
                        ]);

                        if (!empty($this->start_date)) {
                            $rate->start_date = $this->start_date;
                        }

                        if (!empty($this->end_date)) {
                            $rate->end_date = $this->end_date;
                        }
                        $r = $rate->calculateRates;
                        $this->rates = !empty($r[$this->bouquet_id]) ? $r[$this->bouquet_id] : [];

                        $operator = Operator::findOne($this->operator_id);
                        if ($operator instanceof Operator) {
                            if ($operator->balance < $this->rates["total"] && !$this->skip_balance_check) {
                                $this->addError("operator_id", "Required amount is " . $this->rates["total"] . " but found " . $operator->balance);
                            }
                        }
                    }
                }],
            ['username', function () {
                    $user = \common\models\User::findOne(['username' => $this->username]);
                    $account = CustomerAccount::findOne(['username' => $this->username]);
                    if (!empty($user) || !empty($account)) {
                        $this->addError("username", "Username $this->username already taken.");
                        return false;
                    }
                    return TRUE;
                }],
            [['proof', 'charges', 'start_date', 'end_date'], 'safe'],
        ];
    }

    public function beforeValidate() {
        return parent::beforeValidate();
    }

    public function save($runValidation = true, $attributeNames = null) {
        if (!$this->hasErrors()) {
            if ($this->scenario == CustomerAccount::SCENARIO_CREATE) {
                return $this->createCustomer();
            } else if ($this->scenario == self::SCENARIO_RENEW) {
                return $this->renewAccount();
            } else if ($this->scenario == self::SCENARIO_ADDONS) {
                return $this->addons();
            } else if ($this->scenario == self::SCENARIO_SUSPEND_RESUME) {
                return $this->suspendResume();
            } else if ($this->scenario == self::SCENARIO_TERMINATE) {
                return $this->terminateAccount();
            } else if ($this->scenario == self::SCENARIO_CHARGES) {
                return $this->raiseCustomerCharges();
            } else if ($this->scenario == self::SCENARIO_PAYMENT) {
                return $this->makePayment();
            }
        }
        return FALSE;
    }

    public function raiseCustomerCharges() {
        $account = CustomerAccount::findOne(['id' => $this->id]);
        if ($account instanceof CustomerAccount) {
            $model = new CustomerWallet(['scenario' => CustomerWallet::SCENARIO_CREATE]);
            $model->subscriber_id = $account->customer_id;
            $model->account_id = $account->id;
            $model->operator_id = $account->operator_id;
            $model->trans_type = $this->type;
            $model->amount = $this->amount;
            $model->tax = 0;
            $model->remark = $this->remark;
            $model->meta_data = [
                'username' => $account->username,
                'cid' => $account->cid,
                'name' => $account->customerName,
            ];
            if ($model->validate() && $model->save()) {
                return $model;
            }
        }
        return false;
    }

    public function makePayment() {
        $account = CustomerAccount::findOne(['id' => $this->id]);
        if ($account instanceof CustomerAccount) {
            $model = new CustomerWallet(['scenario' => CustomerWallet::SCENARIO_CREATE]);
            $model->subscriber_id = $account->customer_id;
            $model->account_id = $account->id;
            $model->operator_id = $account->operator_id;
            $model->trans_type = C::TRANS_CR_SUBSCRIBER_PAYMENT;
            $model->amount = $this->amount;
            $model->tax = 0;
            $model->remark = $this->remark;
            $model->meta_data = [
                "instrument_mode" => !empty(C::LABEL_PAY_MODE[$this->instrument_mode]) ? C::LABEL_PAY_MODE[$this->instrument_mode] : $this->instrument_mode,
                "instrument_date" => $this->instrument_date,
                "instrument_bank" => $this->instrument_bank,
            ];
            if ($model->validate() && $model->save()) {
                return $model;
            }
        }
        return false;
    }

    public function terminateAccount() {
        $account = CustomerAccount::findOne(['id' => $this->id]);
        if ($account instanceof CustomerAccount) {
            $amount = $mrp = 0;
            $account->scenario = CustomerAccount::SCENARIO_UPDATE;
            $account->status = C::STATUS_TERMINATE;
            $account->end_date = date("Y-m-d");
            $account->addRemark($this->remark);
            if ($account->validate() && $account->save()) {
                $plans = CustomerAccountBouquet::find()->where(['status' => C::STATUS_ACTIVE, 'account_id' => $account->id])
                        ->all();
                foreach ($plans as $plan) {
                    $plan->scenario = CustomerAccountBouquet::SCENARIO_UPDATE;
                    $plan->status = C::STATUS_TERMINATE;
                    $data = $plan->refundData;
                    $plan->refund_amount = $data['amount'];
                    $plan->refund_tax = $data['tax'];
                    $plan->refund_mrp = $data['mrp'];
                    $plan->refund_mrp_tax = $data['mrp_tax'];
                    $meta_data = $plan->meta_data;
                    $meta_data['credit'] = $data;
                    $plan->meta_data = $meta_data;
                    if ($plan->validate() && $plan->save()) {
                        $amount += $plan->refund_amount + $plan->refund_tax;
                        $mrp += $plan->refund_mrp + $plan->refund_mrp_tax;
                        $ds = $this->creditSubscriber($plan);
                        if (!empty($ds)) {
                            $this->creditOperator($plan, $ds->id);
                        }
                    }
                }
                $this->message = "Account {$account->username} terminated and refund of amount {$amount} and mrp {$mrp} done successfully. ";
                return $account;
            }
        }
        return FALSE;
    }

    private function suspendResume() {
        $model = CustomerAccount::findOne(['id' => $this->id]);
        if ($model instanceof CustomerAccount) {
            if ($model->status == C::STATUS_ACTIVE) {
                return $this->inactivateAccount($model);
            } else if (in_array($model->status, [C::STATUS_INACTIVE, C::STATUS_INACTIVATE_REFUND])) {
                return $this->activateAccount($model);
            }
        }
        return false;
    }

    private function inactivateAccount(CustomerAccount $account) {
        if ($this->is_refund) {
            $amount = $mrp = 0;
            $account->scenario = CustomerAccount::SCENARIO_UPDATE;
            $account->status = C::STATUS_INACTIVATE_REFUND;
            $account->end_date = date("Y-m-d");
            if ($account->validate() && $account->save()) {
                $plans = CustomerAccountBouquet::find()->where(['status' => C::STATUS_ACTIVE, 'account_id' => $account->id])->all();
                foreach ($plans as $plan) {
                    $plan->scenario = CustomerAccountBouquet::SCENARIO_UPDATE;
                    $plan->status = C::STATUS_INACTIVATE_REFUND;
                    $data = $plan->refundData;
                    $plan->refund_amount = $data['amount'];
                    $plan->refund_tax = $data['tax'];
                    $plan->refund_mrp = $data['mrp'];
                    $plan->refund_mrp_tax = $data['mrp_tax'];
                    $meta_data = $plan->meta_data;
                    $meta_data['credit'] = $data;
                    $plan->meta_data = $meta_data;
                    if ($plan->validate() && $plan->save()) {
                        $amount += $plan->refund_amount + $plan->refund_tax;
                        $mrp += $plan->refund_mrp + $plan->refund_mrp_tax;
                        $ds = $this->creditSubscriber($plan);
                        if (!empty($ds)) {
                            $this->creditOperator($plan, $ds->id);
                        }
                    }
                }
                $this->message = "Account {$account->username} suspended and refund of amount {$amount} and mrp {$mrp} done successfully. ";
                return $account;
            }
        } else {
            $account->scenario = CustomerAccount::SCENARIO_UPDATE;
            $account->status = C::STATUS_INACTIVE;
            if ($account->validate() && $account->save()) {
                $plans = CustomerAccountBouquet::find()->where(['status' => C::STATUS_ACTIVE, 'account_id' => $account->id])->all();
                foreach ($plans as $plan) {
                    $plan->scenario = CustomerAccountBouquet::SCENARIO_UPDATE;
                    $plan->status = C::STATUS_INACTIVE;
                    if ($plan->validate()) {
                        $plan->save();
                    } else {
                        print_R($plan->errors);
                    }
                }
                return $account;
            }
        }
        return FALSE;
    }

    private function activateAccount(CustomerAccount $account) {
        $account->scenario = CustomerAccount::SCENARIO_UPDATE;
        $currentStatus = $account->status;

        if ($account->status == C::STATUS_INACTIVE) {
            $account->status = ($account->end_date > date("Y-m-d")) ? C::STATUS_ACTIVE : C::STATUS_EXPIRED;
            if ($account->validate() && $account->save()) {
                $plans = CustomerAccountBouquet::find()->where(['status' => $currentStatus, 'account_id' => $account->id])->all();
                if (!empty($plans)) {
                    foreach ($plans as $plan) {
                        $plan->scenario = CustomerAccountBouquet::SCENARIO_UPDATE;
                        $plan->status = ($plan->end_date > date("Y-m-d")) ? C::STATUS_ACTIVE : C::STATUS_EXPIRED;
                        if ($plan->validate()) {
                            $plan->save();
                        }
                    }
                }
                $account->refresh();
                return $account;
            }
        } else if ($account->status == C::STATUS_INACTIVATE_REFUND) {
            $plans = CustomerAccountBouquet::find()->where(['status' => $currentStatus, 'account_id' => $account->id])
                    ->select(['bouquet_id', 'plan_type', 'rate_id'])
                    ->groupBy(['bouquet_id', 'plan_type', 'rate_id'])
                    ->indexBy('bouquet_id')
                    ->all();
            foreach ($plans as $plan) {

                $rate = new RateCalculation([
                    'rate_id' => $plan->rate_id,
                    'assoc_id' => $plan->bouquet_id,
                    'type' => C::RATE_TYPE_BOUQUET,
                    'operator_id' => $account->operator_id,
                    'action_type' => $plan->plan_type == C::PLAN_TYPE_BASE ? RateCalculation::ACTION_TYPE_RENEW : RateCalculation::ACTION_TYPE_ADDON
                ]);
                $r = $rate->calculateRates;
                $data = !empty($r[$plan->bouquet_id]) ? $r[$plan->bouquet_id] : [];
                if (!empty($data) && ($account->operator->balance > $data["total"])) {
                    $this->addPlan($data, $account);
                } else {
                    if ($account->operator->balance > $data["total"]) {
                        $this->message = "Franchise wallet insufficient balance. Please rechare wallet to perform action.";
                    }
                }
            }

            $planDate = CustomerAccountBouquet::find()->where(['status' => C::STATUS_ACTIVE, 'account_id' => $account->id])
                    ->select(['start_date' => 'min(start_date)', 'end_date' => 'max(end_date)'])
                    ->one();
            if (!empty($planDate)) {
                $account->scenario = CustomerAccount::SCENARIO_UPDATE;
                $account->status = C::STATUS_ACTIVE;
                $account->start_date = $planDate->start_date;
                $account->end_date = $planDate->end_date;
                if ($account->validate() && $account->save()) {
                    $account->refresh();
                    return $account;
                }
            }
        }
        return false;
    }

    private function addons() {
        $model = CustomerAccount::findOne(['id' => $this->id]);
        if ($model instanceof CustomerAccount) {
            $data = $this->rates;
            return $this->addPlan($data, $model);
        }
        return FALSE;
    }

    private function renewAccount() {
        $account = CustomerAccount::findOne($this->id);
        if ($account instanceof CustomerAccount) {
            if ($account->status == C::STATUS_ACTIVE && $account->end_date > date("Y-m-d")) {
                return $this->advanceRenewal($account);
            } else {
                return $this->currentRenewal($account);
            }
        }
    }

    private function advanceRenewal(CustomerAccount $account) {
        $model = CustomerAccount::findOne(['id' => $this->id]);
        if ($model instanceof CustomerAccount) {
            $rate = new RateCalculation([
                'assoc_id' => $this->bouquet_id,
                'type' => C::RATE_TYPE_BOUQUET,
                'operator_id' => $this->operator_id,
                'action_type' => $this->action_type,
                'start_date' =>  U::addDays($model->end_date,1),
                "voucher_code" => $this->voucher_code
            ]);
            $r = $rate->calculateRates;
            $this->rates = !empty($r[$this->bouquet_id]) ? $r[$this->bouquet_id] : [];

            $data = $this->rates;
            $model->scenario = CustomerAccount::SCENARIO_UPDATE;
            $model->end_date = $data['display_date'];
            if ($model->validate() && $model->save()) {
                $this->addPlan($data, $model);
                return $model;
            } else {
                $this->addErrors($model->errors);
            }
        }
        return FALSE;
    }

    private function currentRenewal(CustomerAccount $account) {
        $model = CustomerAccount::findOne(['id' => $this->id]);
        if ($model instanceof CustomerAccount) {
            $data = $this->rates;
            $model->scenario = CustomerAccount::SCENARIO_UPDATE;
            $model->start_date = $data['start_date'];
            $model->end_date = $data['display_date'];
            $model->status = $data['status'];
            if ($model->validate() && $model->save()) {
                $this->addPlan($data, $model);
                return $model;
            } else {
                $this->addErrors($model->errors);
            }
        }
        return FALSE;
    }

    private function createCustomer() {
        try {
            $model = new Customer(['scenario' => Customer::SCENARIO_CREATE]);
            $model->load($this->attributes, '');
            if ($model->validate() && $model->save()) {
                $account = $this->addAccount($this->rates, $model);
                $this->id = $model->id;
                if (!empty($account->prospect_id)) {
                    $prospect = new ProspectForm(['id' => $account->prospect_id]);
                    $prospect->closeProspectCall($account);
                }
                return $model;
            } else {
                print_r($model->errors);
                exit;
                $this->addErrors($model->errors);
            }
        } catch (Exception $ex) {
            
        }

        return FALSE;
    }

    public function addAccount($data, Customer $customer) {
        $model = new CustomerAccount(['scenario' => CustomerAccount::SCENARIO_CREATE]);
        $model->cid = $customer->cid;
        $model->customer_id = $customer->id;
        $model->username = $this->username;
        $model->password = $this->password;
        $model->operator_id = $this->operator_id;
        $model->road_id = $this->road_id;
        $model->building_id = $this->building_id;
        $model->router_type = $this->nas_id;
        $model->start_date = $data['start_date'];
        $model->end_date = $data['display_date'];
        $model->status = $data['status'];
        $model->account_types = C::ACCOUNT_TYPE_PPPOE;
        $model->is_auto_renew = $this->is_auto_renew;
        $model->meta_data = [];
        $model->prospect_id = $this->prospect_id;
        if ($model->validate() && $model->save()) {
            $this->addPlan($data, $model);
            $this->generateLogins();
            $this->raiseCharges($model);
            return $model;
        } else {
            print_r($model->attributes);
            print_r($model->errors);
            exit("Accounts");
        }
    }

    public function addPlan($d, CustomerAccount $account) {
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
        $model->plan_type = $d['plan_type'];
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
        $model->voucher_id = $d['voucher_id'];
        $total_amount = $model->amount + $model->tax;
        $total_mrp = $model->mrp + $model->mrp_tax;

        $this->message .= $model->remark = "Plan " . $d['plan_name'] . " activated on username {$account->username} "
                . "from {$model->start_date} & {$model->end_date} and charged amount {$total_amount} and mrp {$total_mrp}.";
        $model->renewal_type = "";
        $model->tax = U::calculateTax($model->amount);
        if ($model->validate() && $model->save()) {
            CustomerAccount::updateAll(['current_plan' => [$model->id]], ['id' => $model->account_id]);
            $voucherWhere = ["id" => $model->voucher_id];
            $voucherUpdate = ["account_id" => $model->account_id, "username" => $model->account->username];
            $ds = $this->debitSubscriber($model);
            if (!empty($ds)) {
                $voucherUpdate['cus_wallet_id'] = $ds->id;
                $do = $this->debitOperator($model, $ds->id);
                if (!empty($do)) {
                    $voucherUpdate['opt_wallet_id'] = $do->id;
                }
            }
            
            if (!empty($model->voucher_id)) {
                $this->updateVouhcers($voucherUpdate, $voucherWhere);
            }

            return $model;
        }
        return FALSE;
    }

    public function updateVouhcers($update, $where) {
        \common\models\VoucherMaster::updateAll($update, $where);
    }

    public function debitOperator(CustomerAccountBouquet $cpa, $transid) {
        $model = new OperatorWallet(['scenario' => OperatorWallet::SCENARIO_CREATE]);
        $model->cr_operator_id = NULL;
        $model->dr_operator_id = $cpa->operator_id;
        $model->operator_id = $cpa->operator_id;
        $model->amount = $cpa->amount;
        $model->tax = $cpa->tax;
        $model->transaction_id = $transid;
        $model->trans_type = C::TRANS_DR_SUBSCRIPTION_CHARGES;
        $model->remark = $cpa->remark;
        $model->meta_data = $cpa->meta_data;
        if ($model->validate() && $model->save()) {
            return $model;
        }
        return false;
    }

    public function debitSubscriber(CustomerAccountBouquet $cap) {
        $model = new CustomerWallet(['scenario' => CustomerWallet::SCENARIO_CREATE]);
        $model->subscriber_id = $cap->customer_id;
        $model->account_id = $cap->account_id;
        $model->operator_id = $cap->operator_id;
        $model->trans_type = C::TRANS_DR_SUBSCRIPTION_CHARGES;
        $model->amount = $cap->mrp;
        $model->bouquet_id = $cap->bouquet_id;
        $model->start_date = $cap->start_date;
        $model->end_date = $cap->end_date;
        $model->tax = $cap->mrp_tax;
        $model->remark = $cap->remark;
        $metaData = $cap->meta_data;
        $metaData['instrument_mode'] = "CASH";
        $metaData['instrument_bank'] = "CASH";
        $metaData['instrument_date'] = date("Y-m-d");
        $model->meta_data = $metaData;
        if ($model->validate() && $model->save()) {
            return $model;
        }
        return false;
    }

    public function generateLogins() {
        $model = new User(['scenario' => User::SCENARIO_CREATE]);
        $model->name = $this->name;
        $model->username = $this->username;
        $model->password = $this->password;
        $model->mobile_no = $this->mobile_no;
        $model->email = $this->email;
        $model->user_type = C::USER_TYPE_SUBSCRIBER;
        $model->reference_id = $this->id;
        $model->designation_id = C::DESIG_SUBSCRIBER;
        $model->status = C::STATUS_ACTIVE;
        if ($model->validate() && $model->save()) {
            return $model;
        }
        return false;
    }

    public function raiseCharges(CustomerAccount $account) {
        if (!empty($this->charges)) {
            foreach ($this->charges as $k => $v) {
                if (!empty($v['type']) && !empty($v['amount'])) {
                    $model = new CustomerWallet(['scenario' => CustomerWallet::SCENARIO_CREATE]);
                    $model->subscriber_id = $account->customer_id;
                    $model->account_id = $account->id;
                    $model->operator_id = $account->operator_id;
                    $model->trans_type = $v['type'];
                    $model->amount = $v['amount'];
                    $model->tax = 0;
                    $model->remark = "Raise amount of {$model->amount}";
                    $meta_data = [
                        'username' => $account->username,
                        'cid' => $account->cid
                    ];

                    if (in_array($v['type'], [C::TRANS_CR_SUBSCRIBER_PAYMENT, C::TRANS_CR_SUBSCRIBER_ONLINE_PAYMENT])) {
                        $meta_data['instrument_date'] = date("Y-m-d");
                        $meta_data['instrument_name'] = "CASH";
                        $meta_data['instrument_nos'] = $account->id;
                    }
                    $model->meta_data = $meta_data;
                    if ($model->validate() && $model->save()) {
                        
                    }
                }
            }
        }
    }

    public function creditOperator(CustomerAccountBouquet $cpa, $transid) {
        $model = new OperatorWallet(['scenario' => OperatorWallet::SCENARIO_CREATE]);
        $model->cr_operator_id = $cpa->operator_id;
        $model->dr_operator_id = NULL;
        $model->operator_id = $cpa->operator_id;
        $model->amount = $cpa->refund_amount;
        $model->tax = $cpa->refund_tax;
        $model->transaction_id = $transid;
        $model->trans_type = C::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES;
        $model->remark = $cpa->remark;
        $model->meta_data = $cpa->meta_data['credit'];
        if ($model->validate()) {
            $model->save();
        }
    }

    public function creditSubscriber(CustomerAccountBouquet $cap) {
        $model = new CustomerWallet(['scenario' => CustomerWallet::SCENARIO_CREATE]);
        $model->subscriber_id = $cap->customer_id;
        $model->account_id = $cap->account_id;
        $model->operator_id = $cap->operator_id;
        $model->trans_type = C::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES;
        $model->amount = $cap->refund_mrp;
        $model->tax = $cap->refund_mrp_tax;
        $model->remark = $cap->remark;
        $model->meta_data = $cap->meta_data['credit'];
        if ($model->validate() && $model->save()) {
            return $model;
        }
    }

}
