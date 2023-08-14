<?php

namespace backend\controllers;

use Yii;
use common\models\PlanMaster;
use common\forms\PlanForm;
use common\models\PlanMasterSearch;
use common\forms\StaticipForm;
use common\models\StaticipMaster;
use common\models\StaticipMasterSearch;
use common\forms\AssignPolicyForm;
use common\ebl\Constants as C;
use common\forms\AssignStaticPolicyForm;
use common\models\BouquetSearch;
use common\forms\BouquetForm;

/**
 * PlanController implements the CRUD actions for PlanMaster model.
 */
class PlanController extends \common\component\BaseAdminController {

    /**
     * Lists all PlanMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PlanMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Add Plan to database
     * @return mixed 
     */
    public function actionAddPlan() {
        $model = new PlanForm(['scenario' => PlanMaster::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            \Yii::$app->getSession()->setFlash('s', "Plan $model->name added successfully");
            return $this->redirect(['plan/index']);
        }

        return $this->render('form-plan', [
                    'model' => $model,
        ]);
    }

    public function actionUpdatePlan($id) {
        $plan = PlanMaster::findOne($id);

        if (!$plan instanceof PlanMaster) {
            \Yii::$app->getSession()->setFlash('e', 'Plan not found');
            return $this->redirect(['plan/policy']);
        }

        $model = new PlanForm(['scenario' => PlanMaster::SCENARIO_UPDATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            \Yii::$app->getSession()->setFlash('s', "Plan $model->name updated successfully");
            return $this->redirect(['plan/index']);
        }

        $model->load($plan->attributes, '');
        return $this->render('form-plan', [
                    'model' => $model,
        ]);
    }

    public function actionStaticip() {
        $searchModel = new StaticipMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('statcip', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddStaticip() {
        $model = new StaticipForm(['scenario' => StaticipMaster::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            \Yii::$app->getSession()->setFlash('s', "Static policy $model->name added successfully");
            return $this->redirect(['plan/staticip']);
        }

        return $this->render('form-staticip', [
                    'model' => $model,
        ]);
    }

    public function actionUpdateStaticip($id) {
        $plan = StaticipMaster::findOne($id);

        if (!$plan instanceof StaticipMaster) {
            \Yii::$app->getSession()->setFlash('e', 'Staticip policy not found');
            return $this->redirect(['plan/staticip']);
        }
        $model = new StaticipForm(['scenario' => StaticipMaster::SCENARIO_UPDATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            \Yii::$app->getSession()->setFlash('s', "Static ip policy $model->name updated successfully");
            return $this->redirect(['plan/staticip']);
        }

        $model->load($plan->attributes, '');
        return $this->render('form-staticip', [
                    'model' => $model,
        ]);
    }

    public function actionAssignStaticip() {
        $apf = new AssignPolicyForm(['scenario' => 'assign-policy']);
        $apf->type = C::RATE_TYPE_STATICIP;
        $apf->load(Yii::$app->request->post());
        if ($apf->validate()) {
            $apf->save();
            \Yii::$app->getSession()->setFlash('s', "Static IP Policy assigned successfully!");
            return $this->redirect(['plan/staticip']);
        }

        $searchModel = new StaticipMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['rates a'])->andWhere(['not', ['a.id' => null]]);
        return $this->render('assign-staticip', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'apf' => $apf
        ]);
    }

    /**
     * Lists all PlanMaster models.
     * @return mixed
     */
    public function actionBouquet() {
        $searchModel = new BouquetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('bouquet', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Add Plan to database
     * @return mixed 
     */
    public function actionAddBouquet() {
        $model = new BouquetForm(['scenario' => \common\models\Bouquet::SCENARIO_CREATE]);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->validate() && $model->save()) {
                $model->save();
                \Yii::$app->getSession()->setFlash('s', "Bouquet $model->name added successfully");
                return $this->redirect(['plan/bouquet']);
            }
        }

        $asset_list = \yii\helpers\ArrayHelper::map(\common\models\BouquetAssets::find()->active()->asArray()->all(),
                        "id", function ($d) {
                            return $d['name'] . " (" . C::LABEL_BOUQUET_ASSET_TYPE[$d['type']] . ")";
                        }, 'type');

        return $this->render('form-bouquet', [
                    'model' => $model,
                    'asset_list' => $asset_list,
        ]);
    }

    public function actionUpdateBouquet($id) {
        $plan = \common\models\Bouquet::findOne($id);

        if (!$plan instanceof \common\models\Bouquet) {
            \Yii::$app->getSession()->setFlash('e', 'Bouquet not found');
            return $this->redirect(['plan/bouquet']);
        }

        $model = new BouquetForm(['scenario' => \common\models\Bouquet::SCENARIO_UPDATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            \Yii::$app->getSession()->setFlash('s', "Bouquet $model->name updated successfully");
            return $this->redirect(['plan/bouquet']);
        }
        $model->load($plan->attributes, '');
        $asset_list = \yii\helpers\ArrayHelper::map(\common\models\BouquetAssets::find()->active()->asArray()->all(),
                        "id", function ($d) {
                            return $d['name'] . " (" . C::LABEL_BOUQUET_ASSET_TYPE[$d['type']] . ")";
                        }, 'type');

        $model->load($plan->attributes, '');

        return $this->render('form-bouquet', [
                    'model' => $model,
                    'asset_list' => $asset_list,
        ]);
    }

    public function actionAssignBouquet() {
        $apf = new AssignPolicyForm(['scenario' => 'assign-policy']);
        $apf->type = AssignPolicyForm::ASSIGN_POLICY;
        if (\Yii::$app->request->post()) {
            $params = \Yii::$app->request->post();
            if ($params['AssignPolicyForm']['flow'] == 1 && !empty($params['AssignPolicyForm']['operator_ids'])) {
                \common\component\Utils::setCache('AssignPolicyForm' . \common\models\User::loggedInUserName(), json_encode($params['AssignPolicyForm']['operator_ids']));
                $searchModel = new \common\models\BouquetSearch();
                $searchModel->ex_operator_id = $params['AssignPolicyForm']['operator_ids'];
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination->pageSize = 500;
                return $this->render('form-wizard', [
                            "view" => "assign-bouquet",
                            "tab_list" => [
                                1 => "Select Franchise",
                                2 => "Select Bouquet to assign"
                            ],
                            "current_tab" => 2,
                            "view_data" => [
                                'searchModel' => $searchModel,
                                'dataProvider' => $dataProvider,
                                'apf' => $apf
                            ]
                ]);
            } else if ($params['AssignPolicyForm']['flow'] == 2 && !empty($params['AssignPolicyForm']['rate_ids'])) {
                $apf->rate_ids = $params['AssignPolicyForm']['rate_ids'];
                $opid = \common\component\Utils::getCache('AssignPolicyForm' . \common\models\User::loggedInUserName());
                $apf->operator_ids = !empty($opid) ? json_decode($opid, 1) : [];
                if ($apf->validate() && $apf->scheduleBulk()) {
                    \Yii::$app->getSession()->setFlash('s', "Bouquet assignment to franchise job scheduled successfully!");
                    return $this->redirect(['plan/bouquet']);
                }
            }
        }

        $searchModel = new \common\models\OperatorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['type' => C::OPERATOR_TYPE_LCO]);
        $dataProvider->query->with(['crAmount', 'drAmount', 'distributor', 'ro', 'city']);
        $dataProvider->pagination->pageSize = 1000;
        return $this->render('form-wizard', [
                    "view" => "assign-operator",
                    "tab_list" => [
                        1 => "Select Franchise",
                        2 => "Select Bouquet to assign"
                    ],
                    "current_tab" => 1,
                    "view_data" => [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'apf' => $apf
                    ]
        ]);
    }

    public function actionDeassignBouquet() {
        $apf = new AssignPolicyForm(['scenario' => 'assign-policy']);
        $apf->type = AssignPolicyForm::DEASSIGN_POLICY;
        if (\Yii::$app->request->post()) {
            $params = \Yii::$app->request->post();
            if ($params['flow'] == 1 && !empty($params['AssignPolicyForm']['operator_ids'])) {
                \common\component\Utils::setCache('AssignPolicyForm' . \common\models\User::currentUser(), $params['AssignPolicyForm']['operator_ids']);
                $searchModel = new \common\models\BouquetSearch();
                $searchModel->operator_id = $params['AssignPolicyForm']['operator_ids'];
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination->pageSize = 500;
                return $this->render('form-wizard', [
                            "view" => "assign-bouquet",
                            "tab_list" => [
                                1 => "Select Franchise",
                                2 => "Select Bouquet to de-assign"
                            ],
                            "current_tab" => 2,
                            "view_data" => [
                                'searchModel' => $searchModel,
                                'dataProvider' => $dataProvider,
                                'apf' => $apf
                            ]
                ]);
            } else if ($params['flow'] == 2 && !empty($params['AssignPolicyForm']['rate_ids'])) {
                $apf->rate_ids = $params['AssignPolicyForm']['rate_ids'];
                $apf->operator_ids = \common\component\Utils::getCache('AssignPolicyForm' . \common\models\User::currentUser());
                if ($apf->validate() && $apf->scheduleBulk()) {
                    \Yii::$app->getSession()->setFlash('s', "Bouquet de-assignment to franchise job scheduled successfully!");
                    return $this->redirect(['plan/bouquet']);
                }
            }
        }

        $searchModel = new \common\models\OperatorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['type' => C::OPERATOR_TYPE_LCO]);
        $dataProvider->query->with(['crAmount', 'drAmount', 'distributor', 'ro', 'city']);
        $dataProvider->pagination->pageSize = 500;
        return $this->render('form-wizard', [
                    "view" => "assign-operator",
                    "tab_list" => [
                        1 => "Select Franchise",
                        2 => "Select Bouquet to de-assign"
                    ],
                    "current_tab" => 1,
                    "view_data" => [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'apf' => $apf
                    ]
        ]);
    }

    public function actionOtt() {
        $searchModel = new \common\models\OttMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('ott', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSynchOtt() {
        return "Will be implemented based on the OTT providers";
    }

    /**
     * Lists all PlanMaster models.
     * @return mixed
     */
    public function actionIppool() {
        $searchModel = new \common\models\IpPoolMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('ippool', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddIppool() {
        $model = new \common\forms\IpPoolForm(['scenario' => \common\models\IpPoolMaster::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "IP Pool {$model->name}({$model->ip_address}) added successfully");
            return $this->redirect(['plan/ippool']);
        }

        return $this->render('form-ippool', [
                    'model' => $model,
        ]);
    }

}
