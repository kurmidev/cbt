<?php

namespace common\forms;

use common\models\Customer;
use common\models\CustomerAccount;
use common\ebl\Constants as C;
use common\models\CustomerWallet;
use common\models\CustomerAccountBouquet;
use common\component\Utils as U;

class AddAccountForm extends \yii\base\Model {

    use \common\models\BaseTraits;

    public $account_id;
    public $subscriber_id;
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
    public $bouquet_id;
    public $addon_ids;
    public $username;
    public $password;
    public $address;
    public $bill_address;
    public $ip_details;
    public $device_details;
    public $charges;
    public $voucher_code;
    public $is_auto_renew;
    public $rates;
    public $trans_grp;
    public $prospect_id;
    public $id;
    public $message;

    public function scenarios() {
        return [
            Customer::SCENARIO_CREATE => ['name', 'email', 'mobile_no', 'phone_no', 'gender', 'dob', 'connection_type', 'operator_id', 'area_id', 'road_id', 'building_id', 'bouquet_id', 'addon_ids', 'username', 'password', 'address', 'bill_address', 'ip_details', 'device_details', 'charges', 'voucher_code', 'is_auto_renew']
        ];
    }

    public function rules(): array {
        $ipValidations = (new \yii\base\DynamicModel(["ipaddress", "start_date", "end_date", "rate_id"]))
                ->addRule(["ipaddress", "start_date", "end_date", "rate_id"], "required")
                ->addRule(["start_date", "end_date"], "date", ["format" => "php:Y-m-d"])
                ->addRule(["ipaddress"], "exist", ['targetClass' => \common\models\IpPoolList::class, 'targetAttribute' => ['ipaddress' => 'ipaddress']])
                ->addRule(["rate_id"], "exist", ['targetClass' => \common\models\IpPoolList::class, 'targetAttribute' => ['ipaddress' => 'ipaddress']]);

        $deviceValidations = (new \yii\base\DynamicModel(['mrp', 'device_id']))
                ->addRule(["mrp", "device_id"], "required")
                ->addRule(['mrp'], 'number')
                ->addRule(["device_id"], "exist", ['targetClass' => \common\models\DeviceInventory::class, 'targetAttribute' => ['id' => 'device_id', "account_id" => null]]);

        return [
            [['name', 'email', 'mobile_no', 'gender', 'connection_type', 'operator_id', 'area_id', 'road_id', 'building_id', 'username', 'password', 'address', 'bill_address', 'is_auto_renew'], "required"],
            [['name', 'email', 'mobile_no', 'phone_no', 'username', 'password', 'address', 'bill_address'], "string"],
            [['connection_type', 'operator_id', 'area_id', 'road_id', 'building_id', 'bouquet_id', 'is_auto_renew'], "integer"],
            ['username', function () {
                    $user = \common\models\User::findOne(['username' => $this->username]);
                    $account = CustomerAccount::findOne(['username' => $this->username]);
                    if (!empty($user) || !empty($account)) {
                        $this->addError("username", "Username $this->username already taken.");
                        return false;
                    }
                    return TRUE;
                }],
            ['voucher_code', function () {
                    $vc = \common\models\VoucherMaster::findOne(['id' => $this->voucher_code, 'operator_id' => $this->operator_id, 'status' => C::VOUCHER_ACTIVE]);
                    if (!$vc instanceof \common\models\VoucherMaster) {
                        $this->addError('voucher_code', 'Voucher is not applicable.');
                    } else {
                        \common\models\VoucherMaster::updateAll(['is_locked' => strtotime('now')], ['id' => $vc->id]);
                    }
                }],
            ['bouquet_id', function () {
                    if (!empty($this->bouquet_id)) {
                        $bouquets = \common\models\OperatorRates::find()->alias('a')->onlyBase()
                                        ->where(['a.operator_id' => $this->operator_id, 'a.id' => $this->bouquet_id])->all();
                        if (empty($bouquets)) {
                            $this->addError("bouquet_id", "Base Bouquet not assigned to franchise.");
                        }
                    }
                }],
            ['addon_ids', function () {
                    if (!empty($this->addon_ids)) {
                        $bouquets = \common\models\OperatorRates::find()->alias('a')->onlyAddons()
                                        ->where(['operator_id' => $this->operator_id, 'id' => $this->addon_ids])->all();
                        if (empty($bouquets)) {
                            $this->addError("addon_ids", "Addons not assigned to franchise.");
                        }
                    }
                }],
                //   [['ip_details'], 'ValidateMulti', 'params' => ['isMulti' => TRUE, 'ValidationModel' => $ipValidations, 'allowEmpty' => true]],
                // [['device_details'], 'ValidateMulti', 'params' => ['isMulti' => false, 'ValidationModel' => $deviceValidations, 'allowEmpty' => true]],
        ];
    }

    public function beforeValidate() {
        if (!empty($this->bouquet_id)) {
            $this->rates = new \common\ebl\RateCalculation([
                'operator_id' => $this->operator_id,
                'bouquet_id' => \yii\helpers\ArrayHelper::merge([$this->bouquet_id], !empty($this->addon_ids) ? $this->addon_ids : []),
                "voucher_code" => $this->voucher_code
            ]);

            $r = $this->rates->getRateDetails();
            if (empty($r)) {
                $this->addError("bouquet_id", "Rates not defined or bouquets not assigned to Franchise");
                return false;
            } else {
                $operator = \common\models\Operator::findOne(['id' => $this->operator_id]);
                if (!$operator->isBalanceAvailable($r['total_amount'] + $r['total_tax'])) {
                    $this->addError("operator_id", "Insufficient balance in Franchise account.");
                    return false;
                }
            }
        }


        return parent::beforeValidate();
    }

    public function save() {
        if (!$this->hasErrors()) {
            $this->trans_grp = uniqid() . time();
            $model = new Customer(['scenario' => Customer::SCENARIO_CREATE]);
            $model->load($this->attributes, '');
            if ($model->validate() && $model->save()) {
                $rates = $this->rates->getRateDetails();
                $this->addAccount($rates, $model);
                $this->id = $model->id;
                return true;
            } else {
                $this->addErrors($model->errors);
            }
        }
        return false;
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
        $model->router_type = null;
        $model->start_date = !empty($data['start_date']) ? $data['start_date'] : null;
        $model->end_date = !empty($data['display_date']) ? $data['display_date'] : null;
        $model->status = !empty($data['status']) ? $data['status'] : C::STATUS_ACTIVE;
        $model->account_types = C::ACCOUNT_TYPE_PPPOE;
        $model->is_auto_renew = $this->is_auto_renew;
        $model->meta_data = [];
        $model->prospect_id = !empty($this->prospect_id) ? $this->prospect_id : 0;
        if ($model->validate() && $model->save()) {
            if (!empty($this->bouquet_id)) {
                $this->addPlans($model);
            }
            if (!empty($this->charges)) {
                $this->raiseCharges($model);
            }
            return $model;
        } else {
            print_r($model->errors);
            exit("wf.scknl");
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
                $this->message .= $model->remark = "Bouquet  " . $d['bouquet_name'] . " activated on username {$account->username} "
                        . "from {$model->start_date} & {$model->end_date} and charged amount {$total_amount} and mrp {$total_mrp}.";
                $model->renewal_type = C::RENEWAL_TYPE_FRESH;
                $model->tax = U::calculateTax($model->amount);
                if ($model->validate() && $model->save()) {
                    $pl_id[] = $model->id;
                }
            }
        }
        return $pl_id;
    }

    public function raiseCharges(CustomerAccount $account) {
        $i = 0;
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
                    $model->remark = (in_array($v['type'], C::TRANSACTION_TYPE_SUB_CREDIT) ? "Received " : "Raised") . " amount of " . CURRENCY . "{$model->amount}  " . C::TRANS_LABEL[$v['type']];
                    $meta_data = [
                        'username' => $account->username,
                        'cid' => $account->cid
                    ];
                    if (in_array($v['type'], [C::TRANS_CR_SUBSCRIBER_PAYMENT, C::TRANS_CR_SUBSCRIBER_ONLINE_PAYMENT])) {
                        $meta_data['instrument_date'] = date("Y-m-d");
                        $meta_data['instrument_name'] = "CASH";
                        $meta_data['instrument_nos'] = "";
                    }
                    $model->meta_data = $meta_data;
                    if ($model->validate() && $model->save()) {
                        $i++;
                    }
                }
            }
        }
        return $i;
    }

}
