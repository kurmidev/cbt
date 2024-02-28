<?php

namespace backend\controllers;

use Yii;
use common\models\VendorMaster;
use common\models\VendorMasterSearch;
use common\models\DeviceMaster;
use common\models\DeviceMasterSearch;

/**
 * InventoryController implements the CRUD actions for Inventory model.
 */
class InventoryController extends \common\component\BaseAdminController {
    /*     * ********************Add Vendor************************************ */

    /**
     * Lists all Location models.
     * @return mixed
     */
    public function actionVendor() {
        $searchModel = new VendorMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('vendor', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddVendor() {
        $model = new VendorMaster(['scenario' => VendorMaster::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Vendor $model->name added successfully.");
            return $this->redirect(['inventory/vendor']);
        }
        return $this->render('form-vendor', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Location model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateVendor($id) {
        $model = VendorMaster::findOne($id);
        $model->scenario = VendorMaster::SCENARIO_UPDATE;
        if (!$model instanceof VendorMaster) {
            \Yii::$app->getSession()->setFlash('e', 'Vendor entry not found');
            return $this->redirect(['inventory/vendor']);
            exit();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Vendor $model->name updated successfully.");
            return $this->redirect(['inventory/vendor']);
        }

        return $this->render('form-vendor', [
                    'model' => $model,
        ]);
    }

    /*     * ********************End Add Vendor******************************** */
    /*     * ******************** Add Devicer******************************** */

    /**
     * Lists all Location models.
     * @return mixed
     */
    public function actionDevice() {
        $searchModel = new DeviceMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('device', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddDevice() {
        $model = new DeviceMaster(['scenario' => DeviceMaster::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Device $model->name added successfully.");
            return $this->redirect(['inventory/device']);
        }
        return $this->render('form-device', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Location model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateDevice($id) {
        $model = DeviceMaster::findOne($id);

        if (!$model instanceof DeviceMaster) {
            \Yii::$app->getSession()->setFlash('e', 'Device entry not found');
            return $this->redirect(['inventory/device']);
            exit();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Device $model->name updated successfully.");
            return $this->redirect(['inventory/device']);
        }

        return $this->render('form-device', [
                    'model' => $model,
        ]);
    }

    /*     * ********************End Add Device******************************** */

    public function actionDeviceRequisition() {
        $searchModel = new \common\models\DeviceRequisitionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('device', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    // public function actionCreateRequisition() {
    //     $model = 
    // }

    /*     * ********************End Device Requisition******************************** */

    public function actionDeviceStock() {
        $searchModel = new \common\models\DeviceInventorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['operator_id' => \common\models\User::loggedInUserReferenceId()]);

        return $this->render('device-stock', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInwardDevice() {
        ini_set('upload_max_filesize', '10M');
        ini_set('post_max_size', '10M');
        $model = new \common\forms\InwardDeviceForm(['scenario' => \common\models\ScheduleJobLogs::SCENARIO_CREATE]);
        $model->type = \common\models\ScheduleJobLogs::FILE_UPLOAD;
        $model->model = \common\ebl\jobs\DeviceInwardJob::class;
        // $model->model_data = ['type' => 1];

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Schedule job with id {$model->id} added successfully.");
            return $this->redirect(['mig/index']);
        }

        return $this->render('form-inward', [
                    'model' => $model,
        ]);
    }

}
