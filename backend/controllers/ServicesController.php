<?php

namespace backend\controllers;

use Yii;
use common\component\BaseAdminController;
use common\models\Broadcaster;
use common\models\BroadcasterSearch;
use common\models\Genre;
use common\models\GenreSearch;
use common\models\Language;
use common\models\LanguageSearch;
use common\models\Services;
use common\models\ServicesSearch;
use common\forms\ServiceForm;
use common\models\PluginsMaster;
use common\ebl\Constants as C;

class ServicesController extends BaseAdminController
{

    /*     * *********************Add Language******************************** */

    /**
     * Lists all Location models.
     * @return mixed
     */
    public function actionLanguage()
    {
        $searchModel = new LanguageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('language', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddLanguage()
    {
        $model = new Language(['scenario' => Language::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['language', 'id' => $model->id]);
        }
        return $this->render('form-language', [
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
    public function actionUpdateLanguage($id)
    {
        $model = Language::findOne($id);

        if (!$model instanceof Language) {
            \Yii::$app->getSession()->setFlash('e', 'Language entry not found');
            return $this->redirect(['services/language']);
            exit();
        }

        $model->scenario = Language::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Language $model->name updated successfully.");
            return $this->redirect(['language']);
        }

        return $this->render('form-language', [
            'model' => $model,
        ]);
    }

      /*     * *********************Add Genre******************************** */

    /**
     * Lists all Location models.
     * @return mixed
     */
    public function actionGenre()
    {
        $searchModel = new GenreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('genre', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddGenre()
    {
        $model = new Genre(['scenario' => Language::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['genre', 'id' => $model->id]);
        }
        return $this->render('form-genre', [
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
    public function actionUpdateGenre($id)
    {
        $model = Genre::findOne($id);

        if (!$model instanceof Genre) {
            \Yii::$app->getSession()->setFlash('e', 'Genre entry not found');
            return $this->redirect(['services/genre']);
            exit();
        }

        $model->scenario = Genre::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Genre $model->name updated successfully.");
            return $this->redirect(['genre']);
        }

        return $this->render('form-genre', [
            'model' => $model,
        ]);
    }

       /*     * *********************Add Broadcaster******************************** */

    /**
     * Lists all Location models.
     * @return mixed
     */
    public function actionBroadcaster()
    {
        $searchModel = new BroadcasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('broadcaster', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddBroadcaster()
    {
        $model = new Broadcaster(['scenario' => Broadcaster::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['broadcaster', 'id' => $model->id]);
        }
        return $this->render('form-broadcaster', [
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
    public function actionUpdateBroadcaster($id)
    {
        $model = Broadcaster::findOne($id);

        if (!$model instanceof Broadcaster) {
            \Yii::$app->getSession()->setFlash('e', 'Broadcaster entry not found');
            return $this->redirect(['services/broadcaster']);
            exit();
        }

        $model->scenario = Broadcaster::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Broadcaster $model->name updated successfully.");
            return $this->redirect(['broadcaster']);
        }

        return $this->render('form-broadcaster', [
            'model' => $model,
        ]);
    }

      /*     * *********************Add Services******************************** */

    /**
     * Lists all Location models.
     * @return mixed
     */
    public function actionServices()
    {
        $searchModel = new ServicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('services', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddServices()
    {
        $model = new ServiceForm(['scenario' => Services::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['services', 'id' => $model->id]);
        }else{
            //dd($model->errors);
        }
        return $this->render('form-services', [
            'model' => $model,
            "plugins"=> PluginsMaster::find()->active()->where(["plugin_type"=> [C::PLUGIN_TYPE_OTT,C::PLUGIN_TYPE_CAS]])->all(),
        ]);
    }

    /**
     * Updates an existing Location model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateServices($id)
    {
        $services = Services::findOne($id);

        if (!$services instanceof Services) {
            \Yii::$app->getSession()->setFlash('e', 'Services entry not found');
            return $this->redirect(['services/services']);
            exit();
        }

        $model = new ServiceForm(['scenario'=> Services::SCENARIO_UPDATE]);
        $model->id = $services->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Services $model->name updated successfully.");
            return $this->redirect(['services']);
        }

        return $this->render('form-services', [
            'model' => $model,
            "plugins"=> PluginsMaster::find()->active()->where(["plugin_type"=> [C::PLUGIN_TYPE_OTT,C::PLUGIN_TYPE_CAS]])->all(),
        ]);
    }
}
