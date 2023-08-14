<?php

namespace backend\controllers;

use Yii;
use common\models\ComplaintSearch;
use common\models\Complaint;

class ComplaintController extends \common\component\BaseAdminController {

    public function actionIndex() {

        $searchModel = new ComplaintSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->query->andWhere(['not', ['status' => C::STATUS_CLOSED]]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProcessComplaint($id) {
        $ps = Complaint::findOne($id);
        if (!$ps instanceof Complaint) {
            \Yii::$app->getSession()->setFlash('e', 'Record not found');
            return $this->redirect(['index']);
        }
        $model = new \common\forms\ComplaintForm(['scenario' => Complaint::SCENARIO_PENDING]);
        $model->id = $ps->id;
        $model->account_id = $ps->account_id;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $message = !empty($model->message) ? $model->message : "Complaint #{$model->ticketno} has been raised successfully.";
            \Yii::$app->getSession()->setFlash('s', $message);
            return $this->redirect(['complaint/index']);
        }

        return $this->render('form-process-complaint', [
                    'customer' => $ps->customer,
                    'account' => $ps->account,
                    'complaint' => $ps,
                    'model' => $model
        ]);
    }

    public function actionViewComplaint($id) {
        $ps = Complaint::findOne($id);
        return $this->render('_complaint_details', [
                    'customer' => $ps->customer,
                    'account' => $ps->account,
                    'complaint' => $ps,
        ]);
    }

}
