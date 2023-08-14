<?php

namespace backend\controllers;

use Yii;
use common\component\BaseAdminController;
use common\models\CustomerAccountSearch;
use common\forms\AccountForm;
use common\models\Customer;
use common\models\CustomerAccount;
use common\ebl\Constants as C;
use common\models\CustomerWallet;
use common\forms\ComplaintForm;

class AccountController extends BaseAdminController {

    public function actionIndex() {
        $searchModel = new CustomerAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['customer', 'operator']);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "search" => $searchModel->advanceSearch()
        ]);
    }

    public function actionView($id) {
        $model = $this->checkAccount($id);

        $credits = (new \common\models\CustomerWalletSearch())->search(Yii::$app->request->queryParams);
        $credits->query->andWhere(['trans_type' => C::TRANSACTION_TYPE_SUB_CREDIT, 'account_id' => $model->id]);

        $debits = (new \common\models\CustomerWalletSearch())->search(Yii::$app->request->queryParams);
        $debits->query->andWhere(['trans_type' => C::TRANSACTION_TYPE_SUB_DEBIT, 'account_id' => $model->id]);

        $subscribed = (new \common\models\CustomerAccountBouquetSearch())->search(Yii::$app->request->queryParams);
        $subscribed->query->andWhere(['account_id' => $model->id]);

        $datausage = (new \common\models\RadiusAccountingSearch())->search(Yii::$app->request->queryParams);
        $datausage->query->andWhere(['username' => $model->username]);

        return $this->render('view', ['model' => $model,
                    'cr' => $credits,
                    'dr' => $debits,
                    'sp' => $subscribed,
                    'ds' => $datausage
        ]);
    }

    public function actionAdd() {
        $model = new \common\forms\AddAccountForm(['scenario' => Customer::SCENARIO_CREATE]);

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $msg = !empty($model->message) ? $model->message : "Account with username $model->username created successfully.";
            \Yii::$app->getSession()->setFlash('s', $msg);
            return $this->redirect(['account/index']);
        }

        return $this->render('form-add', [
                    'model' => $model,
        ]);
    }

    private function checkAccount($id) {
        $account = CustomerAccount::findOne($id);
        if (!$account instanceof CustomerAccount) {
            \Yii::$app->getSession()->setFlash('e', "Account not found.");
            return $this->redirect(['account/index']);
        }
        return $account;
    }

    public function actionRenewal($id) {
        $account = $this->checkAccount($id);
        $model = new \common\forms\RenewAccount(['scenario' => \common\forms\RenewAccount::SCENARIO_RENEW]);
        $model->operator_id = $account->operator_id;
        $model->account_id = $account->id;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $message = !empty($model->message) ? $model->message : "Account with username $account->username renewed successfully.";
            \Yii::$app->getSession()->setFlash('s', $message);
            return $this->redirect(['account/index']);
        }

        return $this->render('form-renew', [
                    'account' => $account,
                    'model' => $model
        ]);
    }

    public function actionAddons($id) {
        $account = $this->checkAccount($id);
        $model = new AccountForm(['scenario' => AccountForm::SCENARIO_ADDONS]);
        $model->operator_id = $account->operator_id;
        $model->id = $account->id;
        $model->action_type = \common\ebl\RateCalculation::ACTION_TYPE_ADDON;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $message = !empty($model->message) ? $model->message : "Account with username $model->username addon added successfully.";
            \Yii::$app->getSession()->setFlash('s', $message);
            return $this->redirect(['account/index']);
        }

        return $this->render('form-addon', [
                    'account' => $account,
                    'model' => $model
        ]);
    }

    public function actionSusres($id) {
        $account = $this->checkAccount($id);
        $model = new AccountForm(['scenario' => AccountForm::SCENARIO_SUSPEND_RESUME]);
        $model->id = $account->id;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $account->refresh();
            $lbl = $account->status == C::STATUS_ACTIVE ? 'resumed' : 'suspended';
            $message = !empty($model->message) ? $model->message : "Account with username $model->username {$lbl} successfully.";
            \Yii::$app->getSession()->setFlash('s', $message);
            return $this->redirect(['account/index']);
        }

        return $this->render('form-suspend-resume', [
                    'account' => $account,
                    'model' => $model
        ]);
    }

    public function actionTerminate($id) {
        $account = $this->checkAccount($id);
        $model = new AccountForm(['scenario' => AccountForm::SCENARIO_TERMINATE]);
        $model->id = $account->id;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $account->refresh();
            $message = !empty($model->message) ? $model->message : "Account with username $model->username terminated successfully.";
            \Yii::$app->getSession()->setFlash('s', $message);
            return $this->redirect(['account/index']);
        }

        return $this->render('form-terminated', [
                    'account' => $account,
                    'model' => $model
        ]);
    }

    public function actionPayment($id) {
        $account = $this->checkAccount($id);
        $model = new AccountForm(['scenario' => AccountForm::SCENARIO_PAYMENT]);
        $model->id = $account->id;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $account->refresh();
            $message = !empty($model->message) ? $model->message : "Payment of amount $model->amount has been credited to account with $model->username successfully.";
            \Yii::$app->getSession()->setFlash('s', $message);
            return $this->redirect(['account/index']);
        }

        return $this->render('form-payment', [
                    'account' => $account,
                    'model' => $model
        ]);
    }

    public function actionCharges($id) {
        $account = $this->checkAccount($id);
        $model = new AccountForm(['scenario' => AccountForm::SCENARIO_CHARGES]);
        $model->id = $account->id;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $account->refresh();
            $message = !empty($model->message) ? $model->message : "Charges of amount $model->amount has been debited from account $model->username successfully.";
            \Yii::$app->getSession()->setFlash('s', $message);
            return $this->redirect(['account/index']);
        }

        return $this->render('form-charges', [
                    'account' => $account,
                    'model' => $model
        ]);
    }

    public function actionComplaint($id) {
        $account = $this->checkAccount($id);
        $model = new ComplaintForm(['scenario' => \common\models\Complaint::SCENARIO_CREATE]);
        $model->account_id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $message = !empty($model->message) ? $model->message : "Complaint #{$model->ticketno} has been raised successfully.";
            \Yii::$app->getSession()->setFlash('s', $message);
            return $this->redirect(['complaint/index']);
        }

        return $this->render('form-complaint', [
                    'account' => $account,
                    'model' => $model
        ]);
    }

}
