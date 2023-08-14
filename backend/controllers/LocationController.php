<?php

namespace backend\controllers;

use Yii;
use common\models\Location;
use common\models\LocationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\ebl\Constants;

/**
 * LocationController implements the CRUD actions for Location model.
 */
class LocationController extends \common\component\BaseAdminController {
    /*     * *********************Add City******************************** */

    /**
     * Lists all Location models.
     * @return mixed
     */
    public function actionCity() {
        $searchModel = new LocationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['type' => Constants::LOCATION_CITY]);

        return $this->render('city', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddCity() {
        $model = new Location(['scenario' => Location::SCENARIO_CREATE]);
        $model->type = Constants::LOCATION_CITY;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['city', 'id' => $model->id]);
        }
        return $this->render('form-city', [
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
    public function actionUpdateCity($id) {
        $model = Location::findOne($id);

        if (!$model instanceof Location) {
            \Yii::$app->getSession()->setFlash('e', 'City entry not found');
            return $this->redirect(['location/city']);
            exit();
        }

        $model->scenario = Location::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "City $model->name updated successfully.");
            return $this->redirect(['city']);
        }

        return $this->render('form-city', [
                    'model' => $model,
        ]);
    }

    /*     * *********************Add Area******************************** */

    /**
     * Lists all Location models.
     * @return mixed
     */
    public function actionArea() {
        $searchModel = new LocationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['type' => Constants::LOCATION_AREA]);

        return $this->render('area', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddArea() {
        $model = new Location(['scenario' => Location::SCENARIO_CREATE]);
        $model->type = Constants::LOCATION_AREA;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['area', 'id' => $model->id]);
        }
        return $this->render('form-area', [
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
    public function actionUpdateArea($id) {
        $model = Location::findOne($id);

        if (!$model instanceof Location) {
            \Yii::$app->getSession()->setFlash('e', 'Record not found');
            return $this->redirect(['location/area']);
            exit();
        }

        $model->scenario = Location::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Area $model->name updated successfully.");
            return $this->redirect(['area']);
        }

        return $this->render('form-area', [
                    'model' => $model,
        ]);
    }

    /*     * *********************Add Road******************************** */

    /**
     * Lists all Location models.
     * @return mixed
     */
    public function actionRoad() {
        $searchModel = new LocationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['type' => Constants::LOCATION_ROAD]);

        return $this->render('road', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddRoad() {
        $model = new Location(['scenario' => Location::SCENARIO_CREATE]);
        $model->type = Constants::LOCATION_ROAD;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['road', 'id' => $model->id]);
        } else {
            if (!empty($model->errors)) {
                print_r($model->errors);
            }
        }
        return $this->render('form-road', [
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
    public function actionUpdateRoad($id) {
        $model = Location::findOne($id);

        if (!$model instanceof Location) {
            \Yii::$app->getSession()->setFlash('e', 'Record not found');
            return $this->redirect(['location/road']);
            exit();
        }

        $model->scenario = Location::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Road $model->name updated successfully.");
            return $this->redirect(['road']);
        }

        return $this->render('form-road', [
                    'model' => $model,
        ]);
    }

    /*     * *********************Add Road******************************** */

    /**
     * Lists all Location models.
     * @return mixed
     */
    public function actionBuilding() {
        $searchModel = new LocationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['type' => Constants::LOCATION_BUILDING]);

        return $this->render('building', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddBuilding() {
        $model = new Location(['scenario' => Location::SCENARIO_CREATE]);
        $model->type = Constants::LOCATION_BUILDING;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['building', 'id' => $model->id]);
        }
        return $this->render('form-building', [
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
    public function actionUpdateBuilding($id) {
        $model = Location::findOne($id);

        if (!$model instanceof Location) {
            \Yii::$app->getSession()->setFlash('e', 'Record not found');
            return $this->redirect(['location/building']);
            exit();
        }

        $model->scenario = Location::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Building $model->name updated successfully.");
            return $this->redirect(['building']);
        }

        return $this->render('form-building', [
                    'model' => $model,
        ]);
    }

}
