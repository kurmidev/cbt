<?php

namespace common\forms;

use common\models\Complaint;
use common\ebl\Constants as C;
use common\models\CustomerAccount;
use common\models\ComplaintDetails;

class ComplaintForm extends \yii\base\Model {

    public $id;
    public $ticketno;
    public $account_id;
    public $remark;
    public $stages;
    public $assigned_user;
    public $nextfollowup;
    public $category_id;
    public $message;
    public $account;

    public function scenarios() {
        return [
            Complaint::SCENARIO_CREATE => ['account_id', 'remark', 'stages', 'assigned_user', 'nextfollowup', 'category_id'],
            Complaint::SCENARIO_PENDING => ['account_id', 'remark', 'stages', 'assigned_user', 'nextfollowup'],
            Complaint::SCENARIO_CLOSED => ['account_id', 'remark', 'stages', 'assigned_user', 'nextfollowup'],
        ];
    }

    public function rules(): array {
        return [
            [['account_id', 'remark', 'assigned_user', 'nextfollowup'], 'required'],
            [['account_id', 'assigned_user', 'stages', 'category_id'], 'integer'],
            [['remark'], 'string', 'min' => 4, "max" => 250],
            ['account_id', function ($attribute, $params, $validator) {
                    $cnt = Complaint::find()->where(['account_id' => $this->account_id, 'stages' => C::COMPLAINT_PENDING])->count();
                    if ($cnt > 0) {
                        $this->addError($attribute, "Complaint alrady active, can't create a new complaaint.");
                    }
                }, 'on' => Complaint::SCENARIO_CREATE]
        ];
    }

    public function attributeLabels() {
        return [
            "category_id" => "Category",
            "nextfollowup" => "Next Follow-up",
        ];
    }

    public function save() {
        if (!$this->hasErrors()) {

            if (!empty($this->id)) {
                $model = Complaint::findOne(['id' => $this->id]);
                if ($model instanceof Complaint) {
                    $this->ticketno = $model->ticketno;
                    if ($model->stages == C::COMPLAINT_CLOSED) {
                        $this->addError("category_id", "Complaint already closed can't update");
                        return false;
                    }
                    return $this->updateComplaint($model);
                }
            } else {
                return $this->createComplaint();
            }
        }
        return false;
    }

    public function updateComplaint(Complaint $c) {
        if ($this->stages == C::COMPLAINT_PENDING) {
            return $this->setDetails($c, true);
        } else {
            $c->scenario = Complaint::SCENARIO_CLOSED;
            $c->closing = $this->remark;
            $c->closing_date = date("Y-m-d H:i:s");
            $c->stages = C::COMPLAINT_CLOSED;
            $c->status = C::COMPLAINT_CLOSED;
            $c->nextfollowup = null;
            if ($c->validate() && $c->save()) {
                $this->setDetails($c, true);
                $this->message = "Ticket #{$c->ticketno} has been marked closed.";
                return true;
            }
        }
        return false;
    }

    public function createComplaint() {
        $account = CustomerAccount::findOne(['id' => $this->account_id]);
        if ($account instanceof CustomerAccount) {
            $model = new Complaint(['scenario' => Complaint::SCENARIO_CREATE]);
            $model->username = $account->username;
            $model->operator_id = $account->operator_id;
            $model->account_id = $account->id;
            $model->customer_id = $account->customer_id;
            $model->category_id = $this->category_id;
            $model->status = C::COMPLAINT_PENDING;
            $model->stages = C::COMPLAINT_PENDING;
            $model->opening = $this->remark;
            $model->current_assigned = $this->assigned_user;
            $model->assigned_to = [["user_id" => $this->assigned_user, "start_date" => date("Y-m-d H:i:s"), "end_date" => ""]];
            $model->opening_date = date("Y-m-d H:i:s");
            $model->nextfollowup = $this->nextfollowup;
            if ($model->validate() && $model->save()) {
                $this->ticketno = $model->ticketno;
                $this->setDetails($model);
                $this->message = "New ticket #{$model->ticketno} has been opened.";
                return true;
            }
        }
        return false;
    }

    public function setDetails(Complaint $c, $is_pending = false) {

        if ($c instanceof Complaint) {
            $model = new ComplaintDetails(['scenario' => ComplaintDetails::SCENARIO_CREATE]);
            $model->account_id = $c->account_id;
            $model->complaint_id = $c->id;
            $model->comments = $this->remark;
            $model->nextfollowup = $this->nextfollowup;
            $model->stage = $c->stages;
            if ($model->validate() && $model->save()) {
                if ($is_pending) {
                    $this->message = "Ticket #{$c->ticketno} details has been updated.";
                    $assigned = $this->setAssignedTo($c->assigned_to, $this->assigned_user);
                    Complaint::updateAll(['assigned_to' => $assigned, 'nextfollowup' => $this->nextfollowup], ['id' => $c->id]);
                }
                return true;
            }
        }
        return false;
    }

    public function setAssignedTo(Array $assigned, $newAssign = "") {
        $lastId = array_slice($assigned, count($assigned) - 1, 1);
        $lastId['end_date'] = date("Y-m-d H:i:s");
        $assigned[] = $lastId;
        if (!empty($newAssign)) {
            $newAssigned = [["user_id" => $newAssign, "start_date" => date("Y-m-d H:i:s"), "end_date" => ""]];
            $assigned[] = $newAssign;
        }

        return $assigned;
    }

}
