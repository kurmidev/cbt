<?php

namespace backend\controllers;

use Yii;
use common\ebl\Constants as C;
use common\component\Utils as U;
use common\models\CustomerWalletSearch;

class CustAccountingController extends \common\component\BaseAdminController {

    public function actionCollections() {
        $searchModel = new CustomerWalletSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(["trans_type" => C::TRANSACTION_TYPE_SUB_COLLECTION]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn("coll"),
                    "title" => " Collections"
        ]);
    }

    public function actionTransactions() {
        $searchModel = new CustomerWalletSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn("trans"),
                    "title" => " Collections"
        ]);
    }

    public function actionMonthlyStatement() {
        $searchModel = new CustomerWalletSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['attributes' => ['subscriber_wallet.id']];
        list($sel, $cond) = U::getCharges(0);
        $dataProvider->query->select(\yii\helpers\ArrayHelper::merge($sel, ['account_id', 'subscriber_id', 'stmonth' => 'left(subscriber_wallet.added_on,7)']))
                ->joinWith(['account', 'customer'])
                ->groupBy(['account_id', 'subscriber_id', 'stmonth']);

        return $this->render('monthly-statement', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCustomerBill() {
        $searchModel = new \common\models\CustomerBillSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    "columns" => $searchModel->displayColumn(),
                    "title" => "Invoice "
        ]);
    }

    public function actionPrintBill($id) {
        $model = \common\models\CustomerBill::findOne(['id' => $id]);
        if ($model instanceof \common\models\CustomerBill) {

            return $this->render("print_bill", [
                        'billby' => $model->operator,
                        'model' => $model,
            ]);
        }

        \Yii::$app->getSession()->setFlash('e', 'Bill not found');
        return $this->redirect(['cust-accounting/opt-print-bill']);
    }

    public function actionPrintStatement($id, $month) {
        $this->layout = 'print';
        list($sel, $cond) = U::getCharges(0);
        $startDate = $month . "-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        $query = \common\models\CustomerWallet::find()->alias('a')
                ->select(\yii\helpers\ArrayHelper::merge($sel,
                                ['a.account_id', 'a.subscriber_id', 'a.operator_id']))
                ->joinWith(['account', 'customer', 'operator'])
                ->andWhere(['between', 'a.added_on', $startDate, $endDate])
                ->andWhere(['a.account_id' => $id])
                ->groupBy(['a.account_id', 'a.subscriber_id', 'a.operator_id']);
        if (!empty($cond)) {
            $query->andWhere(['a.trans_type' => $cond]);
        }
        $model = $query->one();

        return $this->render("print_statement", [
                    'billby' => $model->operator,
                    'model' => $model,
                    'billmonth' => $startDate,
                    'billStartDate' => $startDate,
                    'billEndDate' => $endDate
        ]);
    }

}
