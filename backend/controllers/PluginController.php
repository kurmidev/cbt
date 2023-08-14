<?php

namespace backend\controllers;

use Yii;
use common\models\PluginsMaster;
use common\models\PluginMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PluginController implements the CRUD actions for PluginsMaster model.
 */
class PluginController extends \common\component\BaseAdminController {

    /**
     * Lists all PluginsMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PluginMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new PluginsMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PluginsMaster();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Plugin {$model->name} added successfully.");
            return $this->redirect(['index']);
        }
        return $this->render('form-plugin', [
                    'model' => $model,
        ]);
    }

    public function actionAddSms($id = 0) {
        $model = new \common\forms\SmsForm();
        $model->scenario = empty($id) ? PluginsMaster::SCENARIO_CREATE : PluginsMaster::SCENARIO_UPDATE;
        if (!empty($id)) {
            $model->id = $id;
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $lbl = !empty($id) ? "Plugin {$model->name} updated successfully." : "Plugin {$model->name} added successfully.";
            \Yii::$app->getSession()->setFlash('s', $lbl);
            return $this->redirect(['index']);
        }

        if (!empty($id)) {
            $m = PluginsMaster::findOne($id);
            if ($m instanceof PluginsMaster) {
                $model->load($m->attributes, '');
            }
        }

        return $this->render('form-sms', [
                    'model' => $model,
        ]);
    }

    public function actionAddPg($id = 0) {
        $model = new \common\forms\PgForm();
        $model->scenario = empty($id) ? PluginsMaster::SCENARIO_CREATE : PluginsMaster::SCENARIO_UPDATE;
        if (!empty($id)) {
            $model->id = $id;
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $lbl = !empty($id) ? "Plugin {$model->name} updated successfully." : "Plugin {$model->name} added successfully.";
            \Yii::$app->getSession()->setFlash('s', $lbl);
            return $this->redirect(['index']);
        }

        if (!empty($id)) {
            $m = PluginsMaster::findOne($id);
            if ($m instanceof PluginsMaster) {
                $model->load($m->attributes, '');
                if (!empty($m->pluginsItems)) {
                    foreach ($m->pluginsItems as $d) {
                        $name = $d->name;
                        if ($model->hasProperty($name)) {
                            $model->$name = $d->value;
                        }
                    }
                }
            }
        }

        return $this->render('form-pg', [
                    'model' => $model,
        ]);
    }

    public function actionAddNas($id = 0) {
        $model = new \common\forms\NasForm();
        $model->scenario = empty($id) ? PluginsMaster::SCENARIO_CREATE : PluginsMaster::SCENARIO_UPDATE;
        if (!empty($id)) {
            $model->id = $id;
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $lbl = !empty($id) ? "Plugin {$model->name} updated successfully." : "Plugin {$model->name} added successfully.";
            \Yii::$app->getSession()->setFlash('s', $lbl);
            return $this->redirect(['index']);
        }

        if (!empty($id)) {
            $m = PluginsMaster::findOne($id);
            if ($m instanceof PluginsMaster) {
                $model->load($m->attributes, '');
                if (!empty($m->pluginsItems)) {
                    foreach ($m->pluginsItems as $d) {
                        $name = $d->name;
                        if ($model->hasProperty($name)) {
                            $model->$name = $d->value;
                        }
                    }
                }
            }
        }

        return $this->render('form-nas', [
                    'model' => $model,
        ]);
    }
    
      public function actionAddOtt($id = 0) {
        $model = new \common\forms\OttForm();
        $model->scenario = empty($id) ? PluginsMaster::SCENARIO_CREATE : PluginsMaster::SCENARIO_UPDATE;
        if (!empty($id)) {
            $model->id = $id;
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $lbl = !empty($id) ? "Plugin {$model->name} updated successfully." : "Plugin {$model->name} added successfully.";
            \Yii::$app->getSession()->setFlash('s', $lbl);
            return $this->redirect(['index']);
        }

        if (!empty($id)) {
            $m = PluginsMaster::findOne($id);
            if ($m instanceof PluginsMaster) {
                $model->load($m->attributes, '');
            }
        }

        return $this->render('form-ott', [
                    'model' => $model,
        ]);
    }

    /**
     * Finds the PluginsMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PluginsMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PluginsMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
