<?php

namespace backend\controllers;

use Yii;
use common\models\Nas;
use common\models\NasSearch;
use common\forms\NasForm;

/**
 * NasController implements the CRUD actions for Nas model.
 */
class NasController extends \common\component\BaseAdminController {

    /**
     * Lists all Nas models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new NasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Nas model.
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
     * Creates a new Nas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddNas() {
        $model = new \common\forms\NasForm(['scenario' => Nas::SCENARIO_CREATE]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $m = $model->save();
            if ($m instanceof Nas) {
                \Yii::$app->getSession()->setFlash('s', "Nas $m->name added successfully.");
            } else {
                \Yii::$app->getSession()->setFlash('e', "Some error occured");
            }
            return $this->redirect(['nas/index', 'id' => $model->id]);
        }

        return $this->render('form-nas', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Nas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateNas($id) {
        $nas = Nas::findOne($id);

        if (!$nas instanceof Nas) {
            \Yii::$app->getSession()->setFlash('e', 'Nas entry not found');
            return $this->redirect(['nas/index']);
        }
        $model = new NasForm(['scenario' => Nas::SCENARIO_UPDATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $m = $model->save();
            if ($m instanceof Nas) {
                \Yii::$app->getSession()->setFlash('s', "Nas $m->name updated successfully.");
            } else {
                \Yii::$app->getSession()->setFlash('e', "Some error occured");
            }
            return $this->redirect(['index']);
        }
        $model->load($nas->attributes, '');
        return $this->render('form-nas', [
                    'model' => $model,
        ]);
    }

    public function actionManageNas() {
        
    }

    public function actionActivateNas() {
        
    }

    public function actionRestartNas() {
        
    }

    public function actionFlushUsers() {
        
    }

}
