<?php

namespace backend\controllers;

use Yii;
use common\models\OptPaymentReconsile;
use common\models\OptPaymentReconsileSearch;
use common\component\BaseAdminController;
use common\models\OperatorWalletSearch;
use common\models\OperatorSearch;
use common\ebl\Constants as C;
use common\models\ScheduleJobLogs;

/**
 * OptAccountingController implements the CRUD actions for OptPaymentReconsile model.
 */
class OptAccountingController extends BaseAdminController {

    public function actionOperatorLedger() {
        $searchModel = new OperatorWalletSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(),
                    "title" => C::OPERATOR_TYPE_LCO_NAME . " Legder"
        ]);
    }

    public function actionOperatorCollection() {
        $searchModel = new OperatorWalletSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['trans_type' => C::OPERATOR_COLLECTIONS]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(),
                    "title" => C::OPERATOR_TYPE_LCO_NAME . " Collections"
        ]);
    }

    public function actionOperatorBalance() {
        $searchModel = new OperatorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(-1),
                    "title" => C::OPERATOR_TYPE_LCO_NAME . " Balance"
        ]);
    }

    public function actionOperatorCreditdebit() {
        $searchModel = new OperatorWalletSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['trans_type' => [C::TRANS_CR_OPERATOR_CREDIT_NOTE, C::TRANS_DR_OPERATOR_DEBIT_NOTE]]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(),
                    "title" => C::OPERATOR_TYPE_LCO_NAME . " Credit/Debit"
        ]);
    }

    public function actionDepositInstrument() {
        $searchModel = new OptPaymentReconsileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['status' => C::INST_PENDING]);

        return $this->render('optrecon', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "type" => 1,
                    "columns" => $searchModel->displayColumn(1),
                    "title" => "Reconsillation Step 1: Deposit "
        ]);
    }

    public function actionReconcileInstrument() {

        $searchModel = new OptPaymentReconsileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['status' => C::INST_DEPOSITED]);

        return $this->render('optrecon', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "type" => 2,
                    "columns" => $searchModel->displayColumn(2),
                    "title" => "Reconsillation Step 2: Deposit "
        ]);
    }

    private function reconsileForm($type) {
        $model = new \common\forms\MigrationJobs(['scenario' => ScheduleJobLogs::SCENARIO_CREATE]);
        $model->type = ScheduleJobLogs::FILE_UPLOAD;
        $model->model = $type == 1 ? \common\ebl\jobs\ReconsilationJob::class : \common\ebl\jobs\FinalReconsilationJob::class;
        $model->model_data = ["type" => $type];
        $model->dwnFields = (function () use ($type) {
                    $c = new \common\ebl\jobs\ReconsilationJob();
                    $c->type = $type;
                    $s = $c->scenarios();
                    return [
                "cols" => !empty($s[\common\models\BaseModel::SCENARIO_MIGRATE]) ? $s[\common\models\BaseModel::SCENARIO_MIGRATE] : [],
                "file" => $type == 1 ? "deposit_reconsile_data" : "realize_reconsile_data",
                    ];
                })();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Schedule job with id {$model->id} added successfully.");
            return $this->redirect(['opt-accounting/deposit-instrument']);
        }
        return $this->render('reconcile', [
                    'model' => $model,
                    'type' => $type
        ]);
    }

    public function actionDepositResoncile() {
        return $this->reconsileForm(1);
    }

    public function actionFinalResoncile() {
        return $this->reconsileForm(2);
    }

    public function actionOptReconsile() {
        $searchModel = new OptPaymentReconsileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['status' => C::INST_DEPOSITED]);

        return $this->render('optrecon', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "type" => 2,
                    "columns" => $searchModel->displayColumn(2),
                    "title" => "Reconsillation Step 2: Reconsile "
        ]);
    }

    public function actionOperatorBill() {
        $searchModel = new \common\models\OperatorBillSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(),
                    "title" => "Invoice "
        ]);
    }

    public function actionPrintBill($id) {
        $model = \common\models\OperatorBill::findOne(['id' => $id]);
        if ($model instanceof \common\models\OperatorBill) {
            $billby = $model->operator->billing_by == C::USERTYPE_MSO ? $model->operator->mso : $model->operator->distributor;

            return $this->render("print_bill", [
                        'billby' => $billby,
                        'model' => $model,
                        "operator" => $model->operator
            ]);
        }

        \Yii::$app->getSession()->setFlash('e', 'Bill not found');
        return $this->redirect(['opt-accounting/opt-print-bill']);
    }

    /**
     * Displays a single OptPaymentReconsile model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OptPaymentReconsile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new OptPaymentReconsile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing OptPaymentReconsile model.
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
     * Deletes an existing OptPaymentReconsile model.
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
     * Finds the OptPaymentReconsile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OptPaymentReconsile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = OptPaymentReconsile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionInstrumentStatus() {
        $searchModel = new OptPaymentReconsileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(10),
                    "title" => "Reconsillation Status "
        ]);
    }

}
