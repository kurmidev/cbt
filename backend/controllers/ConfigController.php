<?php

namespace backend\controllers;

use Yii;
use common\models\Reason;
use common\models\ReasonSearch;
use common\models\Designation;
use common\models\DesignationSearch;
use common\models\TaxMaster;
use common\models\TaxMasterSearch;
use common\models\BankMaster;
use common\models\BankMasterSearch;
use common\models\CompCatSearch;
use common\models\CompCat;
use common\models\VoucherMasterSearch;
use common\models\VoucherMaster;

class ConfigController extends \common\component\BaseAdminController {
    /*     * *********************Add Reason******************************** */

    /**
     * Lists all Reason models.
     * @return mixed
     */
    public function actionReason() {
        $searchModel = new ReasonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('reason', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Reason model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddReason() {
        $model = new Reason(['scenario' => Reason::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Reason $model->name added successfully.");
            return $this->redirect(['reason', 'id' => $model->id]);
        }
        return $this->render('form-reason', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Reason model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateReason($id) {
        $model = Reason::findOne($id);

        if (!$model instanceof Reason) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['config/reason']);
            exit();
        }

        $model->scenario = Reason::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Reason $model->name updated successfully.");
            return $this->redirect(['reason']);
        }

        return $this->render('form-reason', [
                    'model' => $model,
        ]);
    }

    /*     * *********************Add designation******************************** */

    /**
     * Lists all Reason models.
     * @return mixed
     */
    public function actionDesignation() {
        $searchModel = new DesignationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->excludeSysDef();
        return $this->render('designation', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Reason model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddDesignation() {
        $model = new Designation(['scenario' => Designation::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Designation $model->name added successfully.");
            return $this->redirect(['designation', 'id' => $model->id]);
        }
        $menus = \backend\component\MenuHelper::reArrangeMenu();
        return $this->render('form-designation', [
                    'model' => $model,
                    'menu' => $menus,
                    'savedMenu' => []
        ]);
    }

    /**
     * Updates an existing Reason model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateDesignation($id) {
        $model = Designation::findOne($id);

        if (!$model instanceof Designation) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['config/designation']);
            exit();
        }

        $model->scenario = Designation::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Designation $model->name updated successfully.");
            return $this->redirect(['designation']);
        }

        $menus = \backend\component\MenuHelper::reArrangeMenu();

        $savedMenu = \Yii::$app->authManager->getChildren($model->code);

        return $this->render('form-designation', [
                    'model' => $model,
                    'menu' => $menus,
                    'savedMenu' => !empty($savedMenu) ? array_keys($savedMenu) : []
        ]);
    }

    /*     * *********************Add Tax******************************** */

    /**
     * Lists all Tax models.
     * @return mixed
     */
    public function actionTax() {
        $searchModel = new TaxMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('tax', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Tax model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddTax() {
        $model = new TaxMaster(['scenario' => TaxMaster::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            \Yii::$app->getSession()->setFlash('s', "Tax $model->name added successfully.");
            return $this->redirect(['tax', 'id' => $model->id]);
        }
        return $this->render('form-tax', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tax model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateTax($id) {
        $model = TaxMaster::findOne($id);

        if (!$model instanceof TaxMaster) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['config/tax']);
            exit();
        }

        $model->scenario = TaxMaster::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Tax $model->name updated successfully.");
            return $this->redirect(['tax']);
        }

        return $this->render('form-tax', [
                    'model' => $model,
        ]);
    }

    /*     * *********************Add Bank Mater******************************** */

    /**
     * Lists all Reason models.
     * @return mixed
     */
    public function actionBank() {
        $searchModel = new BankMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('bank', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Bank model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddBank() {
        $model = new BankMaster(['scenario' => BankMaster::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Bank $model->name added successfully.");
            return $this->redirect(['bank', 'id' => $model->id]);
        }
        return $this->render('form-bank', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Bank model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateBank($id) {
        $model = BankMaster::findOne($id);

        if (!$model instanceof BankMaster) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['config/bank']);
            exit();
        }

        $model->scenario = BankMaster::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Bank $model->name updated successfully.");
            return $this->redirect(['bank']);
        }

        return $this->render('form-bank', [
                    'model' => $model,
        ]);
    }

    /*     * *********************Add Complaints Category******************************** */

    /**
     * Lists all Complaints Category models.
     * @return mixed
     */
    public function actionCompCat() {
        $searchModel = new CompCatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('comp-cat', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Complaint Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddCompCat() {
        $model = new CompCat(['scenario' => CompCat::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Complaint Category $model->name added successfully.");
            return $this->redirect(['comp-cat']);
        }
        return $this->render('form-comp-cat', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Complaint Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateCompCat($id) {
        $model = CompCat::findOne($id);

        if (!$model instanceof CompCat) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['config/comp-cat']);
            exit();
        }

        $model->scenario = CompCat::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Complaint category $model->name updated successfully.");
            return $this->redirect(['bank']);
        }

        return $this->render('form-comp-cat', [
                    'model' => $model,
        ]);
    }

    /*     * *********************Add Coupons Vouchers******************************** */

    /**
     * Lists all Reason models.
     * @return mixed
     */
    public function actionVoucher() {
        $searchModel = new VoucherMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('voucher', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Reason model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionGenVoucher() {
        $model = new \common\forms\GenerateVoucherForm(['scenario' => VoucherMaster::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Voucher $model->count generated successfully.");
            return $this->redirect(['config/voucher']);
        }
        return $this->render('form-genvoucher', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Reason model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAssignVoucher() {
        $model = PeriodMaster::findOne($id);
        if (!$model instanceof PeriodMaster) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['config/period']);
            exit();
        }

        $model->scenario = PeriodMaster::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Period $model->name updated successfully.");
            return $this->redirect(['period']);
        }

        return $this->render('form-period', [
                    'model' => $model,
        ]);
    }

}
