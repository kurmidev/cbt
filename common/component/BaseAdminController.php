<?php

namespace common\component;

use common\component\BaseController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class BaseAdminController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (in_array($action->id, ['accessdenied', 'data', 'logout', 'error']))
                                return true;

                            $name = implode("-", [$action->controller->id, $action->id]);
                            return true;//\Yii::$app->user->can($name);
                        }
                    ],
                ],
                'denyCallback' => function () {
                    if (\Yii::$app->user->isGuest) {
                        return \Yii::$app->response->redirect(['site/login']);
                    } else {
                        return \Yii::$app->response->redirect(['site/accessdenied']);
                    }
                }
            ],
        ];
    }

}
