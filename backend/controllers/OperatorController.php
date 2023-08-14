<?php

namespace backend\controllers;

use Yii;
use common\models\Operator;
use common\models\OperatorSearch;
use yii\web\NotFoundHttpException;
use common\ebl\Constants as C;
use common\forms\OperatorForm;

/**
 * OperatorController implements the CRUD actions for Operator model.
 */
class OperatorController extends \common\component\BaseAdminController {

    /**
     * Lists all Distributor models.
     * @return mixed
     */
    public function actionRo() {
        return $this->_index(C::OPERATOR_TYPE_RO);
    }

    /**
     * Lists all Distributor models.
     * @return mixed
     */
    public function actionDistributor() {
        return $this->_index(C::OPERATOR_TYPE_DISTRIBUTOR);
    }

    /**
     * Lists all LCO models.
     * @return mixed
     */
    public function actionFranchise() {
        return $this->_index(C::OPERATOR_TYPE_LCO);
    }

    private function _index($type) {
        $searchModel = new OperatorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['type' => $type]);

        return $this->render('_index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'type' => $type
        ]);
    }

    public function actionAddRo() {
        return $this->_add(C::OPERATOR_TYPE_RO);
    }

    public function actionAddDistributor() {
        return $this->_add(C::OPERATOR_TYPE_DISTRIBUTOR);
    }

    public function actionAddFranchise() {
        return $this->_add(C::OPERATOR_TYPE_LCO);
    }

    public function _add($type) {
        $model = new OperatorForm(['scenario' => Operator::SCENARIO_CREATE]);
        $model->type = $type;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            $redirect = $type == C::OPERATOR_TYPE_DISTRIBUTOR ? 'distributor' : 'franchise';
            return $this->redirect([$redirect, 'id' => $model->id]);
        }

        return $this->render('_add', [
                    'model' => $model,
                    'type' => $type
        ]);
    }

    public function actionUpdateRo($id) {
        return $this->_update($id, C::OPERATOR_TYPE_RO);
    }

    public function actionUpdateDistributor($id) {
        return $this->_update($id, C::OPERATOR_TYPE_DISTRIBUTOR);
    }

    public function actionUpdateFranchise($id) {
        return $this->_update($id, C::OPERATOR_TYPE_LCO);
    }

    private function getUrl($type, $action) {
        $actionUrl = $type == C::OPERATOR_TYPE_DISTRIBUTOR ? "distributor" :
                ($type == C::OPERATOR_TYPE_RO ? "ro" : "franchise");
        switch ($action) {
            case "list":
                return "operator/$actionUrl";
            case "view":
                return "operator/view-$actionUrl";
            default:
                break;
        }
    }

    private function _update($id, $type) {
        $opt = Operator::findOne(['id' => $id, 'type' => $type]);
        $url = $this->getUrl($type, "list");
        if (!$opt instanceof Operator) {
            \Yii::$app->getSession()->setFlash('e', 'Record not found');
            return $this->redirect([$url]);
            exit();
        }

        $model = new OperatorForm(['scenario' => Operator::SCENARIO_UPDATE]);
        $model->scenario = Operator::SCENARIO_UPDATE;
        $model->load($opt->attributes, '');
        $model->type = $type;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $lbl = $type == C::OPERATOR_TYPE_DISTRIBUTOR ? "Distributor" : "Franchise";
            \Yii::$app->getSession()->setFlash('s', "$lbl $model->name details updated successfully.");
            $url = $this->getUrl($type, "view");
            return $this->redirect([$url, 'id' => $id]);
        } else {
            if (!empty($model->errors)) {
                print_r($model->errors);
            }
        }

        return $this->render('_update', [
                    'model' => $model,
                    'type' => $type,
                    'logo' => $opt->logo
        ]);
    }

    /**
     * Displays a single Operator model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewDistributor($id) {
        return $this->actionView($id);
    }

    public function actionViewFranchise($id) {
        return $this->actionView($id);
    }

    public function actionViewRo($id) {
        return $this->actionView($id);
    }

    private function actionView($id) {
        $model = Operator::find()->defaultCondition()
                        ->andWhere(['id' => $id])
                        ->with(['wallets', 'bouquet'])->one();

//        $wallet = (new \common\models\OperatorWalletSearch())->search(Yii::$app->request->queryParams);
//        $wallet->query->andWhere(['operator_id' => $id]);
//
//        $plans = (new \common\models\OperatorRatesSearch())->search(Yii::$app->request->queryParams);
//        $plans->query->andWhere(['operator_id' => $id, 'type' => C::RATE_TYPE_BOUQUET]);
//
//        $staticip = (new \common\models\OperatorRatesSearch())->search(Yii::$app->request->queryParams);
//        $staticip->query->andWhere(['operator_id' => $id, 'type' => C::RATE_TYPE_STATICIP]);

        return $this->render('view', [
                    'model' => $model,
                    'w_provider' => $model->wallet,
                    'p_provider' => $model->bouquet,
                    'w_staicip' => $model->static
//                        'w_provider' => $wallet,
//                        'p_provider'  => $plans,
//                        'w_staicip' => $staticip
        ]);
    }

    public function actionRechargeDistributor($id) {
        return $this->_recharge(C::OPERATOR_TYPE_DISTRIBUTOR, $id);
    }

    public function actionRechargeFranchise($id) {
        return $this->_recharge(C::OPERATOR_TYPE_LCO, $id);
    }

    private function _recharge($type, $id) {
        $opt = $this->findModel($id);
        $url = $this->getUrl($type, "list");
        if (!$opt instanceof Operator) {
            \Yii::$app->getSession()->setFlash('e', 'Record not found');
            return $this->redirect([$url]);
            exit();
        }

        $model = new \common\forms\Recharge();
        $model->id = $opt->id;
        $model->name = $opt->name;
        $model->balance = $opt->balance;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->mode == C::PAY_MODE_PAYMENT_GATEWAY) {
                return $this->OptCheckout($model->attributes);
            }
            $data = $model->save();
            $lbl = $type == C::OPERATOR_TYPE_DISTRIBUTOR ? "Distributor" : "Franchise";
            \Yii::$app->getSession()->setFlash('s', "$lbl $model->name wallet recharged with amount {$data->amount} successfully.");
            $url = $this->getUrl($type, "view");
            return $this->redirect([$url, 'id' => $id]);
            exit(0);
        }
        return $this->render('_recharge', ['model' => $model, "pglist" => \yii\helpers\ArrayHelper::map(\common\component\Utils::activePG(), 'gateway', 'gateway')]);
    }

    public function OptCheckout(Array $data) {
        $this->layout = false;
        $config = [
            "gateway" => $data['pg_id'],
            "isSubscriber" => 0,
            "userId" => $data['id'],
            "amount" => $data['amount'],
            "operator_id" => $data['id'],
            "remark" => $data['remark'],
        ];

        $model = new \common\ebl\payment\PG($config);
        $data = $model->initiatePayment();
        return $this->render('/payment/checkout', ['d' => $data]);
    }

    public function actionChangePassword() {
        return '';
    }

    /**
     * Creates a new Operator model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Operator();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Operator model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Operator model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Operator model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Operator the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Operator::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddMrp($id) {
        $operator = Operator::findOne($id);
        if ($operator instanceof Operator) {

            if (!empty(Yii::$app->request->post())) {
                $params = Yii::$app->request->post();
                if (!empty($params['mrp'])) {
                    $rates = \common\models\OperatorRates::find()->where(['id' => array_keys($params['mrp'])])->all();
                    foreach ($rates as $rate) {
                        $rate->mrp = $params['mrp'][$rate->id];
                        $rate->mrp_tax = \common\component\Utils::calculateTax($rate->mrp);
                        $rate->save();
                    }
                    $actionText = $operator->type == C::OPERATOR_TYPE_DISTRIBUTOR ? "distributor" : "franchise";
                    \Yii::$app->getSession()->setFlash('s', 'MRP updated successfully');
                    return $this->redirect(["operator/view-$actionText", "id" => $id]);
                }
            }


            if (!empty($operator->bouquet)) {
                $plans = (new \common\models\OperatorRatesSearch())->search(Yii::$app->request->queryParams);
                $plans->query->andWhere(['operator_id' => $id]);

                return $this->render('add-mrp', [
                            'model' => $plans,
                ]);
            }
        }
        \Yii::$app->getSession()->setFlash('e', 'Data not found');
        return $this->redirect(['operator/franchise']);
    }

    public function actionAddStaticMrp($id) {
        $operator = Operator::findOne($id);
        if ($operator instanceof Operator) {
            if (!empty(Yii::$app->request->post())) {
                $params = Yii::$app->request->post();
                if (!empty($params['mrp'])) {
                    $rates = \common\models\OperatorRates::find()->where(['id' => array_keys($params['mrp'])])->all();
                    foreach ($rates as $rate) {
                        $rate->mrp = $params['mrp'][$rate->id];
                        $rate->mrp_tax = \common\component\Utils::calculateTax($rate->mrp);
                        $rate->save();
                    }
                    $actionText = $operator->type == C::OPERATOR_TYPE_DISTRIBUTOR ? "distributor" : "franchise";
                    \Yii::$app->getSession()->setFlash('s', 'Static IP MRP updated successfully');
                    return $this->redirect(["operator/view-$actionText", "id" => $id]);
                }
            }


            if (!empty($operator->planRate)) {
                $plans = (new \common\models\OperatorRatesSearch())->search(Yii::$app->request->queryParams);
                $plans->query->andWhere(['operator_id' => $id, 'type' => C::RATE_TYPE_BOUQUET]);

                return $this->render('_mrp-list', [
                            'model' => $plans,
                ]);
            }
        }
        \Yii::$app->getSession()->setFlash('e', 'Data not found');
        return $this->redirect(['operator/franchise']);
    }

    public function actionCreditDebit($id) {
        $opt = $this->findModel($id);
        $url = $this->getUrl($type = "", "list");
        if (!$opt instanceof Operator) {
            \Yii::$app->getSession()->setFlash('e', 'Record not found');
            return $this->redirect([$url]);
            exit();
        }

        $model = new \common\forms\CreditDebit();
        $model->operator_id = $opt->id;
        $model->name = $opt->name;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', $model->msg);
            $url = $this->getUrl($type, "view");
            return $this->redirect([$url, 'id' => $id]);
            exit(0);
        }
        return $this->render('_raise_notes', ['model' => $model, 'opt' => $opt]);
    }

}
