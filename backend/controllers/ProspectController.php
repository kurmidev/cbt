<?php

namespace backend\controllers;

use Yii;
use common\models\ProspectSubscriberSearch;
use common\models\ProspectSubscriber;
use common\forms\ProspectForm;
use common\ebl\Constants as C;
use common\forms\AccountForm;

class ProspectController extends \common\component\BaseAdminController {

    public function actionIndex() {

        $searchModel = new ProspectSubscriberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->query->andWhere(['not', ['status' => C::STATUS_CLOSED]]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddProspect() {
        $model = new ProspectForm(['scenario' => ProspectSubscriber::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $m = $model->save();
            \Yii::$app->getSession()->setFlash('s', "Prospect $m->ticket_no updated successfully.");
            return $this->redirect(['index']);
        }
        return $this->render('form-create-prospect', [
                    'model' => $model,
        ]);
    }

    public function actionProcessRequest($id) {
        $ps = ProspectSubscriber::findOne($id);
        if (!$ps instanceof ProspectSubscriber) {
            \Yii::$app->getSession()->setFlash('e', 'Record not found');
            return $this->redirect(['index']);
        }

        if (in_array($ps->stages, [C::PROSPECT_FINAL_VERIFY])) {
            return $this->createSubscriber($ps);
        } else {
            return $this->processProspect($ps);
        }
    }

    public function createSubscriber(ProspectSubscriber $ps) {
        $model = new AccountForm(['scenario' => ProspectSubscriber::SCENARIO_CREATE]);

        if ($model->load(Yii::$app->request->post())) {
            $model->prospect_id = $ps->id;
            if ($model->validate() && $model->save()) {
                \Yii::$app->getSession()->setFlash('s', "Account with username $model->username created successfully.");
                return $this->redirect(['index']);
            }
        }
        $model->load($ps->attributes, '');
        return $this->render('add_subscriber', [
                    'lbl' => C::PROSPECT_SATGES[$ps->stages],
                    'ps' => $ps,
                    'model' => $model,
        ]);
    }

    public function processProspect(ProspectSubscriber $ps) {
        $model = new ProspectForm(['scenario' => C::PROSPECT_SATGES[$ps->stages]]);
        $model->stages = $ps->stages;
        $model->id = $ps->id;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Prospect customer $model->name stage updated successfully.");
            return $this->redirect(['index']);
        }
        $model->load($ps->attributes, '');
        return $this->render('form-process-request', [
                    'lbl' => C::PROSPECT_SATGES[$ps->stages],
                    'model' => $model,
        ]);
    }

}
