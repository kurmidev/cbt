<?php

namespace console\controllers;

use common\ebl\Constants as C;
use common\component\Utils as U;
use common\models\CustomerAccount;
use common\models\CustomerAccountBouquet;
use common\forms\AccountForm;
use common\models\ScheduleJobLogs;

class PolicyController extends BaseConsoleController {

    public $start_date;
    public $end_date;
    public $response;

    public function setDate($date) {
        $this->start_date = !empty($date) ? date("Y-m-d 00:00:00", strtotime($date)) : date("Y-m-d 00:00:00");
        $this->end_date = !empty($date) ? date("Y-m-d 23:59:00", strtotime($date)) : date("Y-m-d 23:59:59");
    }

    public function actionAutoRenew($date = "") {
        $this->setDate($date);
        $this->cron_name = "auto_renew";
        $username = [];
        $accountObj = CustomerAccount::find()->where(['is_auto_renew' => C::STATUS_ACTIVE, 'status' => [C::STATUS_ACTIVE, C::STATUS_EXPIRED]])
                ->andWhere(['between', 'end_date', $this->start_date, $this->end_date]);
        foreach ($accountObj->batch() as $accounts) {
            foreach ($accounts as $account) {
                $username[] = $account->username;
                $lastPlan = $account->lastBasePlan;
                $model = new AccountForm(['scenario' => AccountForm::SCENARIO_RENEW]);
                $model->operator_id = $account->operator_id;
                $model->id = $account->id;
                $model->rate_id = $lastPlan->rate_id;
                $model->plan_id = $lastPlan->plan_id;
                $model->action_type = \common\ebl\RateCalculation::ACTION_TYPE_RENEW;
                $model->start_date = date("Y-m-d", strtotime($lastPlan->end_date . " +1 day"));
                if ($model->validate() && $model->save()) {
                    $pl = $model->rates;
                    $this->success_record++;
                    $this->response[] = "$account->username auto renewed with plan  " . $pl['plan_name'] . " from " . $pl['start_date'] . " and " . $pl['end_date'] . ".";
                } else {
                    $this->error_record++;
                    $error = $model->getErrorSummary(true);
                    $this->response[] = "Account $account->username renewal error." . implode(" ", $error);
                }
                $this->total_record++;
            }
        }
        $this->savetoQueue($accountObj->where, $username);
    }

    public function actionExpiry($date = "") {
        $this->setDate($date);
        $this->cron_name = "account_expiry";
        $username = [];
        $accountObj = CustomerAccount::find()->where(['status' => [C::STATUS_ACTIVE, C::STATUS_INACTIVE]])
                ->andWhere(['between', 'end_date', $this->start_date, $this->end_date]);
        foreach ($accountObj->batch() as $accounts) {
            foreach ($accounts as $account) {
                $lastPlan = $account->lastBasePlan;
                if (strtotime($lastPlan->end_date) <= strtotime(date("Y-m-d"))) {
                    $username[] = $account->username;
                    $account->scenario = CustomerAccount::SCENARIO_UPDATE;
                    $account->status = C::STATUS_EXPIRED;
                    if ($account->validate() && $account->save()) {
                        $plans = CustomerAccountBouquet::find()
                                ->where(['status' => [C::STATUS_ACTIVE, C::STATUS_INACTIVE], 'account_id' => $account->id])
                                ->all();
                        foreach ($plans as $plan) {
                            $plan->scenario = CustomerAccountBouquet::SCENARIO_UPDATE;
                            $plan->status = C::STATUS_EXPIRED;
                            if ($plan->validate()) {
                                $plan->save();
                            }
                        }
                        //router coa packets tobe send
                        $this->success_record++;
                        $this->response[] = "Account {$account->username} expired as expiry date is reached.";
                    } else {
                        $this->response[] = "Account {$account->username} expiry isses." . implode(" ", $account->getErrorSummary(true));
                        $this->error_record++;
                    }
                    $this->total_record++;
                }
            }
        }
        $this->savetoQueue($accountObj->where, $username);
    }

    public function actionPolicyManagement() {
        
    }

}
