<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\forms\LoginForm;
use common\models\User;
use common\forms\ChangePasswordForm;
use common\ebl\Constants as C;
use common\models\UserSearch;
use common\forms\UserForm;

/**
 * Site controller
 */
class SiteController extends \common\component\BaseAdminController {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return parent::behaviors();
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionChangesPassword() {
        $model = new ChangePasswordForm(['scenario' => User::SCENARIO_CREATE]);
        $name = User::loggedInUserName();
        $model->user_id = User::loggedInUserId();
        $model->name = $name;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $m = $model->save();
            \Yii::$app->getSession()->setFlash('s', "Password of $name updated successfully.");
            return $this->redirect(['index']);
        }
        return $this->render('form-change-password', [
                    'model' => $model,
        ]);
    }

    public function actionProfile() {
        $userType = User::loggedInUserType();
        if (in_array($userType, [C::USERTYPE_OPERATOR, C::USERTYPE_MSO])) {
            $this->redirect(['operator/view', 'id' => User::loggedInUserReferenceId()]);
        }
        $model = User::findOne(['id' => User::loggedInUserId()]);
        return $this->render('form-user', ['model' => $model, 'isReadonly' => TRUE]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionUser() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['user_type' => [C::USERTYPE_MSO, C::USERTYPE_STAFF, C::USERTYPE_OPERATOR]]);

        return $this->render('user', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddUser() {
        $model = new UserForm(['scenario' => User::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "User $model->name added successfully.");
            return $this->redirect(['site/user']);
        }
        return $this->render('form-user', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateUser($id) {
        $user = User::findOne($id);

        if (!$user instanceof User) {
            \Yii::$app->getSession()->setFlash('e', 'User not found');
            return $this->redirect(['site/user']);
        }
        $model = new UserForm(['scenario' => User::SCENARIO_UPDATE]);
        $model->id = $user->id;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            \Yii::$app->getSession()->setFlash('s', "User $model->name updated successfully");
            return $this->redirect(['site/user']);
        }

        $model->load($user->attributes, '');
        $model->password = "";
        return $this->render('form-user', [
                    'model' => $model,
        ]);
    }

    public function actionAccessdenied() {
        return $this->render('accessdenied');
    }

    public function actionAssignOperator($id) {
        $user = User::findOne($id);

        if (!$user instanceof User) {
            \Yii::$app->getSession()->setFlash('e', 'User not found');
            return $this->redirect(['site/user']);
        }

        $model = new \common\forms\AssignmentForm();
        $model->type = C::ASSIGNMENT_TYPE_OPERATOR;
        $model->user_id = $user->id;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', $model->msg);
            return $this->redirect(['site/user']);
        }
        $searchModel = new \common\models\OperatorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['or', ['id' => $user->reference_id], ['distributor_id' => $user->reference_id], ['mso_id' => $user->reference_id]]);

        return $this->render('form-assign', [
                    'model' => $model,
                    'user' => $user,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]);
    }

}
