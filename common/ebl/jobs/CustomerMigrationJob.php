<?php

namespace common\ebl\jobs;

use common\forms\AccountForm;
use common\models\CustomerAccount;
use common\models\Operator;
use common\models\Location;
use common\models\PlanMaster;
use common\ebl\Constants as C;

class CustomerMigrationJob extends BaseJobs {

    public $name;
    public $username;
    public $password;
    public $mobile_no;
    public $phone_no;
    public $email;
    public $gender;
    public $dob;
    public $connection_type;
    public $connection_type_code;
    public $operator_id;
    public $operator_code;
    public $building_id;
    public $building_code;
    public $nas_id;
    public $nas_code;
    public $end_date;
    public $start_date;
    public $address;
    public $bill_address;
    public $is_auto_renew;
    public $status;
    public $plan_id;
    public $plan_code;
    public $rate_id;
    public $rate_code;
    public $area_id;
    public $road_id;

    public function scenarios() {
        return [
            CustomerAccount::SCENARIO_CREATE => ['name', 'username', 'password', 'mobile_no', 'phone_no', 'email', 'gender', 'dob', 'connection_type', 'operator_id', 'building_id', 'nas_id', 'start_date', 'end_date', 'address', 'bill_address', 'is_auto_renew', 'status', 'plan_id', 'rate_id'],
            CustomerAccount::SCENARIO_MIGRATE => ['name', 'username', 'password', 'mobile_no', 'phone_no', 'email', 'gender', 'dob', 'connection_type_code', 'operator_code', 'building_code', 'nas_code', 'start_date', 'end_date', 'address', 'bill_address', 'is_auto_renew', 'status', 'plan_code', 'rate_code'],
        ];
    }

    public function rules() {
        return [
            [['name', 'username', 'password', 'mobile_no', 'connection_type_code', 'operator_code', 'building_code', 'nas_code', 'start_date', 'end_date', 'address', 'plan_code', 'rate_code'], "required"],
            [['name', 'username', 'password', 'mobile_no', 'phone_no', 'email', 'connection_type_code', 'operator_code', 'building_code', 'nas_code', 'address', 'bill_address', 'plan_code', 'rate_code'], "string"],
            ["operator_code", function ($attribute, $params, $validator) {
                    $model = Operator::find()->where(['or', ['name' => $this->operator_code], ['code' => $this->operator_code]])->one();
                    if ($model instanceof Operator) {
                        $this->operator_id = $model->id;
                    } else {
                        $this->addError($attribute, "Invalid Franchise Code");
                    }
                }],
            ["rate_code", function ($attribute, $params, $validator) {
                    $model = \common\models\RateMaster::find()->where(['name' => $this->rate_code])->one();
                    if ($model instanceof \common\models\RateMaster) {
                        $this->rate_id = $model->id;
                    } else {
                        $this->addError($attribute, "Invalid Rate Code");
                    }
                }],
            ["building_code", function ($attribute, $params, $validator) {
                    $model = Location::find()->where(['or', ['name' => $this->building_code], ['code' => $this->building_code]])
                                    ->andWhere(['type' => C::LOCATION_BUILDING])->one();
                    if ($model instanceof Location) {
                        $this->building_id = $model->id;
                        $this->area_id = $model->area_id;
                        $this->road_id = $model->road_id;
                    } else {
                        $this->addError($attribute, "Invalid Building Code");
                    }
                }],
            ["plan_code", function ($attribute, $params, $validator) {
                    $model = PlanMaster::find()->alias('a')
                            ->innerJoin(\common\models\OperatorAssoc::tableName() . " b", "b.assoc_id=a.id and b.type=" . C::RATE_TYPE_BOUQUET)
                            ->where(['or', ['a.name' => $this->plan_code], ['a.code' => $this->plan_code]])
                            ->andWhere(['b.operator_id' => $this->operator_id])
                            ->one();
                    if (!empty($model)) {
                        $this->plan_id = $model->id;
                    } else {
                        $this->addError($attribute, "Invalid Plan Code");
                    }
                }],
            ["connection_type_code", function ($attribute, $params, $validator) {
                    $r = array_flip(C::LABEL_CONNECTION_TYPE);
                    if (!empty($r[$this->connection_type_code])) {
                        $this->connection_type = $r[$this->connection_type_code];
                    } else {
                        $this->addError($attribute, "Invalid Connection type Code");
                    }
                }],
            ["gender", function ($attribute, $param, $validator) {
                    $d = [];
                    foreach (C::LABEL_GENDER as $i => $v) {
                        $d[strtolower($v)] = $i;
                    }
                    if (!empty($d[strtolower($this->gender)])) {
                        $this->gender = $d[strtolower($this->gender)];
                    } else {
                        $this->addError($attribute, "Invalid gender code ");
                    }
                }],
            ["nas_code", function ($attribute, $param, $validator) {
                    $model = \common\models\Nas::find()->where(['or', ['name' => $this->nas_code], ['code' => $this->nas_code]])
                                    ->active()->one();
                    if ($model instanceof \common\models\Nas) {
                        $this->nas_id = $model->id;
                    } else {
                        $this->addError($attribute, "Invalid Nas Code");
                    }
                }]
        ];
    }

    public function _execute($data) {
        $this->scenario = CustomerAccount::SCENARIO_MIGRATE;

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
            $model = new AccountForm(['scenario' => CustomerAccount::SCENARIO_CREATE]);
            $model->load($this->attributes, '');
            $model->skip_balance_check = true;
            $model->start_date = date("Y-m-d", strtotime($this->start_date));
            $model->end_date = date("Y-m-d", strtotime($this->end_date));
            $model->dob = !empty($this->dob) ? date("Y-m-d", strtotime($this->dob)) : null;

            if ($model->validate() && $model->save()) {
                $this->successCnt++;
                $this->response[$this->count]['message'] = "Ok";
                return true;
            } else {
                print_R($model->attributes);
                print_r($model->errors);

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
