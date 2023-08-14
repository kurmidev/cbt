<?php

namespace common\ebl\jobs;

use common\models\Operator;
use common\models\Location;
use common\ebl\Constants as C;

class OperatorMigrationJob extends BaseJobs {

    public $name;
    public $code;
    public $contact_person;
    public $mobile_no;
    public $telephone_no;
    public $email;
    public $address;
    public $distributor_code;
    public $distributor_id;
    public $ro_id;
    public $ro_code;
    public $status;
    public $city_code;
    public $city_id;
    public $state_id;
    public $gst_no;
    public $pan_no;
    public $tan_no;
    public $username;
    public $is_verified;
    public $billing_by_type;
    public $designation_code;
    public $designation_id;
    public $type;
    public $billing_by;
    public $password;

    public function scenarios() {
        return [
            Operator::SCENARIO_MIGRATE => ["name", "code", "contact_person", "mobile_no", "email", "telephone_no", "billing_by_type", "username", "distributor_code", "ro_code", "status", "city_code"
                , "gst_no", "pan_no", "tan_no", "designation_code", "password", "address"],
            Operator::SCENARIO_CREATE => ["name", "code", "contact_person", "mobile_no", "email", "telephone_no", "billing_by", "billing_by_type", "username", "distributor_code", "ro_code", "status", "city_code", "city_id",
                "gst_no", "pan_no", "tan_no", "address", "type", "password", "designation_code", "designation_id"],
        ];
    }

    public function rules() {
        return [
            [["name", "contact_person", "mobile_no", "billing_by_type", "username", "status", "city_code", "password"], "required"],
            ["email", "email"],
            [["name", "contact_person", "mobile_no", "email", "username", "city_code"], "string"],
            [["type", "billing_by", "city_id", "status"], "integer"],
            ["city_code", function ($attribute, $params, $validator) {
                    $model = Location::find()->where(['or', ['name' => $this->city_code], ['code' => $this->city_code]])->one();
                    if ($model instanceof Location) {
                        $this->state_id = $model->state_id;
                        $this->city_id = $model->id;
                    } else {
                        $this->addError($attribute, "Invalid City Code");
                    }
                }],
            ["billing_by_type", function ($attribute, $param, $validator) {
                    $d = array_flip(C::OPERATOR_TYPE_LABEL);
                    if (!empty($d[$this->billing_by_type])) {
                        $this->billing_by = $d[$this->billing_by_type];
                    } else {
                        $this->addError($attribute, "Invalid Billed by code ");
                    }
                }],
            ["ro_code", function ($attribute, $param, $validator) {
                    if (!empty($this->ro_code)) {
                        $model = Operator::find()->where(['or', ['name' => $this->ro_code], ['code' => $this->ro_code]])->one();
                        if ($model instanceof Operator) {
                            $this->ro_id = $model->id;
                        } else {
                            $validator->addError($this, $attribute, "Invalid RO code or name");
                        }
                    }
                }],
            ["distributor_code", function ($attribute, $param, $validator) {
                    if (!empty($this->distributor_code)) {
                        $model = Operator::find()->where(['or', ['name' => $this->distributor_code], ['code' => $this->distributor_code]])->one();
                        if ($model instanceof Operator) {
                            $this->distributor_id = $model->id;
                        } else {
                            $validator->addError($this, $attribute, "Invalid Distributor code or name");
                        }
                    }
                }],
            ["designation_code", function ($attribute, $param, $validator) {
                    if (!empty($this->designation_code)) {
                        $model = \common\models\Designation::find()->where(['or', ['name' => $this->designation_code], ['code' => $this->designation_code]])->one();
                        if ($model instanceof \common\models\Designation) {
                            $this->designation_id = $model->id;
                        } else {
                            $validator->addError($this, $attribute, "Invalid Designation code or name");
                        }
                    }
                }],
        ];
    }

    public function _execute($data) {
        $this->scenario = Operator::SCENARIO_CREATE;
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
            $model = new \common\forms\OperatorForm(['scenario' => Operator::SCENARIO_CREATE]);
            $model->name = $this->name;
            $model->code = $this->code;
            $model->contact_person = $this->contact_person;
            $model->mobile_no = $this->mobile_no;
            $model->telephone_no = $this->telephone_no;
            $model->email = $this->email;
            $model->address = $this->address;
            $model->distributor_id = $this->distributor_id;
            $model->status = $this->status;
            $model->city_id = $this->city_id;
            $model->gst_no = $this->gst_no;
            $model->pan_no = $this->pan_no;
            $model->tan_no = $this->tan_no;
            $model->billing_by = $this->billing_by;
            $model->username = $this->username;
            $model->password = $this->password;
            $model->designation_id = $this->designation_id;
            $model->ro_id = $this->ro_id;
            if (!empty($model->ro_id) && !empty($model->distributor_id)) {
                $model->type = C::OPERATOR_TYPE_LCO;
            } else if (!empty($model->ro_id) && empty($model->distributor_id)) {
                $model->type = C::OPERATOR_TYPE_DISTRIBUTOR;
            } else {
                $model->type = C::OPERATOR_TYPE_RO;
            }
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
