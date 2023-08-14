<?php

namespace common\forms;

use common\models\ProspectSubscriber as PS;
use common\models\ProspectReply;
use common\ebl\Constants as C;

class ProspectForm extends \yii\base\Model {

    public $id;
    public $name;
    public $mobile_no;
    public $dob;
    public $address;
    public $email;
    public $phone_no;
    public $gender;
    public $connection_type;
    public $area_name;
    public $description;
    public $next_follow;
    public $verified_by;
    public $verified_on;
    public $status;
    public $remark;
    public $stages;
    public $assigned_engg;

    const SCENARIO_KYC = "KYC";
    const SCENARIO_INSTALLATION = "Installation";
    const SCENARIO_VERIFICATION = "Finalize";
    const SCENARIO_CLOSED = "CLOSED";

    public function scenarios() {
        return [
            PS::SCENARIO_CREATE => ['id', 'name', 'mobile_no', 'address', 'email', 'phone_no', 'gender', 'connection_type', 'area_name', 'description', 'next_follow', 'dob', 'assigned_engg'],
            PS::SCENARIO_CONSOLE => ['id', 'name', 'mobile_no', 'address', 'email', 'phone_no', 'gender', 'connection_type', 'area_name', 'description', 'next_follow', 'dob', 'assigned_engg'],
            self::SCENARIO_KYC => ['name', 'mobile_no', 'address', 'description', 'email', 'phone_no', 'gender', 'connection_type', 'area_name', 'remark', 'next_follow', 'dob', 'verified_by', 'verified_on', 'status', 'stages', 'assigned_engg'],
            self::SCENARIO_INSTALLATION => ['id', 'name', 'mobile_no', 'description', 'address', 'email', 'phone_no', 'gender', 'connection_type', 'area_name', 'description', 'next_follow', 'dob', 'stages', 'assigned_engg'],
            self::SCENARIO_VERIFICATION => ['id', 'name', 'mobile_no', 'description', 'address', 'email', 'phone_no', 'gender', 'connection_type', 'area_name', 'description', 'next_follow', 'dob', 'stages', 'assigned_engg'],
        ];
    }

    public function rules() {
        return [
            [['name', 'mobile_no', 'address', 'connection_type', 'area_name', 'description'], 'required'],
            [['name', 'mobile_no', 'address', 'email', 'phone_no', 'area_name', 'description', 'remark'], 'string'],
            [['gender', 'connection_type', 'verified_by', 'status', 'stages', 'assigned_engg'], 'integer'],
            [['next_follow', 'dob', 'verified_on'], 'safe']
        ];
    }

    public function save($runValidation = true, $attributeNames = null) {

        if (!$this->hasErrors()) {
            if (empty($this->stages)) {
                return $this->createProspect();
            } else {
                if ($this->stages == C::PROSPECT_VERIFY) {
                    return $this->scheduleInstallation();
                } else if ($this->stages == C::PROSPECT_INSTALLATION) {
                    return $this->scheduleFinalVerification();
                } else if ($this->stages == C::PROSPECT_FINAL_VERIFY) {
                    return $this->closeProspectCall();
                }
            }
        } else {
            print_R($this->errors);
            exit(".wdsmlkwedlka");
        }
        return false;
    }

    public function scheduleInstallation() {
        $model = PS::findOne(['id' => $this->id]);
        if ($model instanceof PS) {
            $model->scenario = PS::SCENARIO_UPDATE;
            $model->stages = $this->status == C::STATUS_PENDING ? $model->stages : C::PROSPECT_INSTALLATION;
            $model->name = $this->name;
            $model->mobile_no = $this->mobile_no;
            $model->email = $this->email;
            $model->phone_no = $this->phone_no;
            $model->gender = $this->gender;
            $model->connection_type = $this->connection_type;
            $model->address = $this->address;
            $model->area_name = $this->area_name;
            $model->is_verified = $this->status == C::STATUS_PENDING ? NULL : 1;
            $model->is_verified_on = $this->verified_on;
            $model->is_verified_by = $this->verified_by;
            $model->next_follow = $this->next_follow;
            $model->assigned_engg = $this->status == C::STATUS_PENDING ? NULL : $this->assigned_engg;
            if ($model->validate() && $model->save()) {
                $this->setProspectReply($model);
                return $model;
            }
        }
    }

    public function scheduleFinalVerification() {
        $model = PS::findOne(['id' => $this->id]);
        if ($model instanceof PS) {
            $model->scenario = PS::SCENARIO_UPDATE;
            $model->stages = $this->status == C::STATUS_PENDING ? $model->stages : C::PROSPECT_FINAL_VERIFY;
            $model->name = $this->name;
            $model->mobile_no = $this->mobile_no;
            $model->email = $this->email;
            $model->phone_no = $this->phone_no;
            $model->gender = $this->gender;
            $model->connection_type = $this->connection_type;
            $model->address = $this->address;
            $model->area_name = $this->area_name;
            $model->next_follow = $this->next_follow;
            if ($model->validate() && $model->save()) {
                $this->setProspectReply($model);
                return $model;
            }
        }
    }

    public function closeProspectCall(\common\models\CustomerAccount $account) {
        $model = PS::findOne(['id' => $this->id]);
        if ($model instanceof PS) {
            $model->scenario = PS::SCENARIO_UPDATE;
            $model->stages = C::PROSPECT_CALL_CLOSED;
            $model->account_id = $account->id;
            $model->operator_id = $account->operator_id;
            $model->subscriber_id = $account->customer_id;
            $model->status = C::STATUS_CLOSED;
            if ($model->validate() && $model->save()) {
                $this->setProspectReply($model);
                return $model;
            }
        }
    }

    public function createProspect() {
        $model = new PS(['scenario' => PS::SCENARIO_CREATE]);
        $model->name = $this->name;
        $model->mobile_no = $this->mobile_no;
        $model->email = $this->email;
        $model->phone_no = $this->phone_no;
        $model->gender = $this->gender;
        $model->connection_type = $this->connection_type;
        $model->address = $this->address;
        $model->area_name = $this->area_name;
        $model->description = $this->description;
        $model->stages = \common\ebl\Constants::PROSPECT_VERIFY;
        $model->status = \common\ebl\Constants::STATUS_PENDING;
        $model->next_follow = $this->next_follow;
        if ($model->validate() && $model->save()) {
            $this->id = $model->id;
            $this->setProspectReply($model);
            return $model;
        } else {
            $this->addErrors($model->errors);
            print_R($model->errors);
            exit;
        }
        return $model;
    }

    public function setProspectReply(PS $ps) {
        $model = new ProspectReply(['scenario' => ProspectReply::SCENARIO_CREATE]);
        $model->prospect_id = $ps->id;
        $model->remark = $ps->description;
        $model->stages = $ps->stages;
        $model->status = $ps->status;
        $model->action_assigned = empty($ps->assigned_engg) ? $ps->assigned_engg : (!empty($ps->is_verified_by) ? $ps->is_verified_by : $ps->updated_by);
        $model->action_taken = $this->remark;
        $model->start_on = date("Y-m-d");
        $model->done_on = NULL;
        $model->meta_data = [
            'name' => $ps->name,
            'mobile_no' => $ps->mobile_no,
            'email' => $ps->email,
            'phone_no' => $ps->phone_no,
            'gender' => !empty(C::LABEL_GENDER[$ps->gender]) ? C::LABEL_GENDER[$ps->gender] : $ps->gender,
            'connection_type' => !empty(C::LABEL_CONNECTION_TYPE[$ps->connection_type]) ? C::LABEL_CONNECTION_TYPE[$ps->connection_type] : $ps->connection_type,
            'address' => $ps->address,
            'area_name' => $ps->area_name
        ];
        $model->ticketno = $ps->ticket_no;
        if ($model->validate() && $model->save()) {
            $query = new \yii\db\Query();
            $query->where(['done_on' => null, 'prospect_id' => $ps->id]);
            $query->andWhere(['<', 'id', $model->id]);
            ProspectReply::updateAll(['done_on' => date("Y-m-d")], $query->where);
        }
    }

}
