<?php

namespace backend\controllers;

use Yii;
use common\models\CustomerAccountSearch;
use common\models\CustomerAccountBouquetSearch;
use common\ebl\Constants as C;
use common\models\ProspectSubscriberSearch;

class ReportController extends \common\component\BaseAdminController {

    public function actionActiveCustomer() {
        $searchModel = new CustomerAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['customer', 'operator'])->andWhere([$dataProvider->query->talias . 'status' => C::STATUS_ACTIVE]);
        $dataProvider->pagination->pageSize = 100;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(),
                    "title" => "Active Customer",
                    "search" => $searchModel->advanceSearch()
        ]);
    }

    public function actionInactiveCustomer() {
        $searchModel = new CustomerAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['customer', 'operator'])->andWhere([$dataProvider->query->talias . 'status' => [C::STATUS_INACTIVE, C::STATUS_INACTIVATE_REFUND]]);
        $dataProvider->pagination->pageSize = 100;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(),
                    "title" => "In-Active Customer",
                    "search" => $searchModel->advanceSearch()
        ]);
    }

    public function actionExpiredCustomer() {
        $searchModel = new CustomerAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['customer', 'operator'])->andWhere([$dataProvider->query->talias . 'status' => [C::STATUS_EXPIRED]]);
        $dataProvider->pagination->pageSize = 100;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(),
                    "title" => "Expired Customer",
                    "search" => $searchModel->advanceSearch()
        ]);
    }

    public function actionRenewal() {
        $searchModel = new CustomerAccountBouquetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['customer', 'operator', 'account']);
        $dataProvider->pagination->pageSize = 100;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(),
                    "title" => "Renewal Customer",
                    "search" => $searchModel->advanceSearch()
        ]);
    }

    public function actionComplaint() {
        $searchModel = new \common\models\ComplaintSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['customer', 'operator', 'account']);
        $dataProvider->pagination->pageSize = 100;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(),
                    "title" => "Complaint",
                    "search" => $searchModel->advanceSearch()
        ]);
    }

    public function actionProspect() {
        $searchModel = new ProspectSubscriberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 100;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(),
                    "title" => "Expired Customer",
                    "search" => $searchModel->advanceSearch()
        ]);
    }

    public function actionPlanSummary() {
        $searchModel = new CustomerAccountBouquetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['plan p'])->defaultCondition()
                ->select([$dataProvider->query->talias . 'plan_id', $dataProvider->query->talias . 'plan_type',
                    'active' => "sum(case when {$dataProvider->query->talias}end_date>='" . date("Y-m-d") . "' and {$dataProvider->query->talias}status=" . C::STATUS_ACTIVE . " then 1 else 0 end)",
                    'inactive' => "sum(case when {$dataProvider->query->talias}status in (" . C::STATUS_INACTIVE . "," . C::STATUS_INACTIVATE_REFUND . ") then 1 else 0 end)",
                    'expiry' => "sum(case when {$dataProvider->query->talias}end_date<'" . date("Y-m-d") . "' and {$dataProvider->query->talias}status=" . C::STATUS_EXPIRED . " then 1 else 0 end)",
                ])
                ->groupBy([$dataProvider->query->talias . 'plan_type', $dataProvider->query->talias . 'plan_id']);
        $dataProvider->sort->defaultOrder = [];
        $dataProvider->pagination->pageSize = 100;

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn('plsum'),
                    "title" => "Plan Summary",
                    "search" => $searchModel->advanceSearch('plsum')
        ]);
    }

    public function actionFranPlan() {
        $searchModel = new CustomerAccountBouquetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith(['plan p', 'operator o'])->defaultCondition()
                ->select([$dataProvider->query->talias . 'operator_id', 'p.name', $dataProvider->query->talias . 'plan_id', $dataProvider->query->talias . 'plan_type',
                    'active' => "sum(case when {$dataProvider->query->talias}end_date>='" . date("Y-m-d") . "' and {$dataProvider->query->talias}status=" . C::STATUS_ACTIVE . " then 1 else 0 end)",
                    'inactive' => "sum(case when {$dataProvider->query->talias}status in (" . C::STATUS_INACTIVE . "," . C::STATUS_INACTIVATE_REFUND . ") then 1 else 0 end)",
                    'expiry' => "sum(case when {$dataProvider->query->talias}end_date<'" . date("Y-m-d") . "' and {$dataProvider->query->talias}status=" . C::STATUS_EXPIRED . " then 1 else 0 end)"
                ])
                ->groupBy(['p.name', $dataProvider->query->talias . 'operator_id', $dataProvider->query->talias . 'plan_type', $dataProvider->query->talias . 'plan_id']);
        $dataProvider->sort->defaultOrder = [];
        $dataProvider->pagination->pageSize = 100;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn('plopt'),
                    "title" => "Franchise Vs Plans",
                    "search" => $searchModel->advanceSearch('plopt')
        ]);
    }

    public function actionFranCustomer() {
        $searchModel = new CustomerAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->select([$dataProvider->query->talias . 'operator_id',
            'active' => "sum(case when {$dataProvider->query->talias}end_date>='" . date("Y-m-d") . "' and {$dataProvider->query->talias}status=" . C::STATUS_ACTIVE . " then 1 else 0 end)",
            'inactive' => "sum(case when {$dataProvider->query->talias}status in (" . C::STATUS_INACTIVE . "," . C::STATUS_INACTIVATE_REFUND . ") then 1 else 0 end)",
            'expired' => "sum(case when {$dataProvider->query->talias}end_date<'" . date("Y-m-d") . "' and {$dataProvider->query->talias}status=" . C::STATUS_EXPIRED . " then 1 else 0 end)",
        ])->joinWith(['operator'])->groupBy([$dataProvider->query->talias . 'operator_id']);
        $dataProvider->sort->defaultOrder = [];
        $dataProvider->pagination->pageSize = 100;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn('optcnt'),
                    "title" => "Franchise Vs Customer",
                    "search" => $searchModel->advanceSearch('optcnt')
        ]);
    }

}
