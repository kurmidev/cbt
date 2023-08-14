<?php

namespace backend\controllers;

use Yii;
use common\models\CustomerAccountSearch;

class BulkController extends \common\component\BaseAdminController {

    public function actionRenewAccounts() {
        $model = new \common\forms\AccountRenewJobs();
        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->scheduleBulk()) {
                \Yii::$app->getSession()->setFlash('s', "Account renewal job scheduled successfully!");
                return $this->redirect(['mig/index', 'ScheduleJobLogsSearch[_id]' => $model->job_id]);
            }
        }

        $searchModel = new CustomerAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->needtoRenew();

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn('renew', 'AccountRenewJobs'),
                    "title" => "Renew Account",
                    "search" => $searchModel->advanceSearch(),
                    "model" => $model
        ]);
    }

    public function actionSuspendResume() {
        $model = new \common\forms\SuspendResumeJobs();
        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->scheduleBulk()) {
                \Yii::$app->getSession()->setFlash('s', "Account Suspend/Resume job scheduled successfully!");
                return $this->redirect(['mig/index', 'ScheduleJobLogsSearch[_id]' => $model->job_id]);
            }
        }
        $searchModel = new CustomerAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('suspend-resume', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn('renew', 'SuspendResumeJobs'),
                    "title" => "Suspend/Resume Account",
                    "search" => $searchModel->advanceSearch(),
                    "model" => $model
        ]);
    }

    public function actionAttrRefresh() {
        $model = new \common\forms\BulkRefreshJobs();
        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->scheduleBulk()) {
                \Yii::$app->getSession()->setFlash('s', "Account bulk refresh job scheduled successfully!");
                return $this->redirect(['mig/index', 'ScheduleJobLogsSearch[_id]' => $model->job_id]);
            }
        }
        $searchModel = new CustomerAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn('renew', 'BulkRefreshJobs'),
                    "title" => "Bulk Refresh",
                    "search" => $searchModel->advanceSearch(),
                    "model" => $model
        ]);
    }

    public function actionTerminate() {
        $model = new \common\forms\BulkTerminateJobs();
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->scheduleBulk()) {
                \Yii::$app->getSession()->setFlash('s', "Account bulk terminate job scheduled successfully!");
                return $this->redirect(['mig/index', 'ScheduleJobLogsSearch[_id]' => $model->job_id]);
            }
        }
        $searchModel = new CustomerAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn('renew', 'BulkTerminateJobs'),
                    "title" => "Bulk Terminate",
                    "search" => $searchModel->advanceSearch(),
                    "model" => $model
        ]);
    }

    public function actionCustomerShift() {
        $model = new \common\forms\BulkCustomerShiftJobs();
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->scheduleBulk()) {
                \Yii::$app->getSession()->setFlash('s', "Bulk customer job scheduled successfully!");
                return $this->redirect(['mig/index', 'ScheduleJobLogsSearch[_id]' => $model->job_id]);
            }
        }
        $searchModel = new CustomerAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('customer-shift', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn('renew', 'BulkCustomerShiftJobs'),
                    "title" => "Bulk Customer Shifting",
                    "search" => $searchModel->advanceSearch(),
                    "model" => $model
        ]);
    }

}
