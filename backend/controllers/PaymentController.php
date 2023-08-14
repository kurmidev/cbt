<?php

namespace backend\controllers;

use common\ebl\payment\PG;

class PaymentController extends \common\component\BaseAdminController {

    public $enableCsrfValidation = false;

    public function actionGwRes($pg) {
        $this->layout = false;
        $params = \Yii::$app->request->isPost ? \Yii::$app->request->post() : \Yii::$app->request->get();
        if (!empty($params) && $pg) {
            $data = [
                "gateway" => $pg,
            ];
            $model = new PG($data);
            $res = $model->processPayment($params);
            if (!empty($res)) {
                return $this->redirect(\Yii::$app->urlManager->createUrl(['payment/receipt', 'order_id' => $res->order_id]));
            }
        }
        return $this->redirect(['payment/error']);
    }

    public function actionReceipt($order_id) {
        $this->layout = 'print';
        $model = \common\models\OnlinePayments::findOne(['order_id' => $order_id]);
        if (!$model instanceof \common\models\OnlinePayments) {
            \Yii::$app->getSession()->setFlash('e', 'Online order not found.');
            return $this->redirect(['payment/error']);
            exit();
        }

        return $this->render('receipt', [
                    'model' => $model,
        ]);
    }

}
