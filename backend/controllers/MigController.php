<?php

namespace backend\controllers;

use Yii;
use common\models\ScheduleJobLogs;
use common\models\ScheduleJobLogsSearch;

class MigController extends \common\component\BaseAdminController {

    /**
     * Lists all ScheduleJobLogs models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ScheduleJobLogsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       // $dataProvider->query->andWhere(['type' => ScheduleJobLogs::FILE_UPLOAD]);
        return $this->render('index', [
                    'type' => ScheduleJobLogs::FILE_UPLOAD,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMigrationJobs() {
        ini_set('upload_max_filesize', '10M');
        ini_set('post_max_size', '10M');
        $model = new \common\forms\MigrationJobs(['scenario' => ScheduleJobLogs::SCENARIO_CREATE]);
        $model->type = ScheduleJobLogs::FILE_UPLOAD;
       // $model->model_data = ['type' => 1];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Schedule job with id {$model->id} added successfully.");
            return $this->redirect(['index']);
        }
      
        return $this->render('form-migration', [
                    'model' => $model,
        ]);
    }

    public function actionDownloadSample($rel, $filename) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        if (!empty($rel)) {
            $data = explode(",", $rel);
            $fp = fopen('php://output', 'wb');
            fputcsv($fp, $data);
            fclose($fp);
        }
    }

    public function actionDownload($id) {
        $model = ScheduleJobLogs::findOne(['_id' => (int) $id]);
        if ($model instanceof ScheduleJobLogs) {
            if (!empty($model->response)) {
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $model->_id . '.csv"');
                $fp = fopen('php://output', 'wb');
                $i = 0;
                foreach ($model->response as $row) {
                    if ($i == 0) {
                        fputcsv($fp, array_keys($row));
                        $i++;
                    }
                    fputcsv($fp, $row);
                }
            }
        }
    }

    public function actionBulkActivity() {
        $searchModel = new ScheduleJobLogsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['type' => ScheduleJobLogs::DATA_UPLOAD]);
        return $this->render('index', [
                    'type' => ScheduleJobLogs::DATA_UPLOAD,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBulkActivityJob() {
        $model = new \common\forms\BulkActivityJobs(['scenario' => ScheduleJobLogs::SCENARIO_CREATE]);
        $model->type = ScheduleJobLogs::FILE_UPLOAD;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Schedule job with id {$model->id} added successfully.");
            return $this->redirect(['index']);
        }
        return $this->render('form-bulkactivity', [
                    'model' => $model,
        ]);
    }

    public function actionRegularJobs() {
        
    }

}
