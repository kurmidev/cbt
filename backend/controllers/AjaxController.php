<?php

namespace backend\controllers;

use common\models\Location;
use common\ebl\Constants as C;
use common\models\Operator;
use common\component\Utils as U;

class AjaxController extends \common\component\BaseAdminController {

    public function actionData($func) {
        $func = "get$func";
        if (method_exists($this, $func)) {
            $params = \Yii::$app->request->get();
            return $this->$func($params);
        }
    }

    public function getVoucher($params = []) {
        $search = new \common\models\VoucherMasterSearch();
        $params = ['VoucherMasterSearch' => $params];
        $ser = $search->search($params);
        $res = $ser->query->active()->all();
        $this->getSelectData($res);
    }

    public function getOperators($params = []) {
        $search = new \common\models\OperatorSearch();
        $params = ['OperatorSearch' => $params];
        $ser = $search->search($params);
        $res = $ser->query->active()->excludeSysDef()->all();
        $this->getSelectData($res);
    }

    public function getPlan($params = []) {
        $search = new \common\models\BouquetSearch();
        $params = ['BouquetSearch' => $params];
        $ser = $search->search($params);
        $res = $ser->query->active()->excludeSysDef()->all();
        $this->getSelectData($res);
    }

    public function getPlanRate($params = []) {
        $search = new \common\models\OperatorRatesSearch();
        $params = ['OperatorRatesSearch' => $params];
        $ser = $search->search($params);
        $res = $ser->query->onlyBase()->all();
        echo "<option value=''>Select options</option>";
        foreach ($res as $m) {
            echo "<option value='" . $m->id . "'>" . $m->bouquet->name . "(LCO : " . ($m->amount + $m->tax) . ", MRP :" . ($m->mrp + $m->mrp_tax) . ")" . "</option>";
        }
    }

    public function getAddonsRate($params = []) {
        $search = new \common\models\OperatorRatesSearch();
        $params = ['OperatorRatesSearch' => $params];
        $ser = $search->search($params);
        $res = $ser->query->onlyAddons()->all();
        echo "<option value=''>Select options</option>";
        foreach ($res as $m) {
            echo "<option value='" . $m->id . "'>" . $m->bouquet->name . "(LCO : " . ($m->amount + $m->tax) . ", MRP :" . ($m->mrp + $m->mrp_tax) . ")" . "</option>";
        }
    }

    public function getFreeDevice($params = []) {
        $search = new \common\models\DeviceInventorySearch();
        $params = ['DeviceInventorySearch' => $params];
        $ser = $search->search($params);
        $res = $ser->query->all();
        echo "<option value=''>Select options</option>";
        foreach ($res as $m) {
            echo "<option value='" . $m->id . "'>" . $m->serial_no . "</option>";
        }
    }

    public function getLocation($params = []) {
        $search = new \common\models\LocationSearch();
        $params = ['LocationSearch' => $params];
        $ser = $search->search($params);
        $res = $ser->query->active()->excludeSysDef()->all();
        $this->getSelectData($res);
    }

    public function getRates($params = []) {
        $search = new \common\models\OperatorRatesSearch();
        $params = ['OperatorRatesSearch' => $params];
        $ser = $search->search($params);
        $res = $ser->query->excludeSysDef()->all();

        if (!empty($res)) {
            echo "<option value=''>Select options</option>";
            foreach ($res as $m) {
                echo "<option value='" . $m->rate_id . "'>" . $m->name . "</option>";
            }
        }
    }

    public function getParticulars($params) {
        $model = new \common\models\OperatorWalletSearch();
        $params = ['OperatorWalletSearch' => $params];
        $ser = $model->search($params);
        $res = $ser->query->andWhere(['between', 'added_on', date("Y-m-d 00:00:00", strtotime("-3 month")), date("Y-m-d 23:59:59")])->all();

        echo "<option value=''>Select options</option>";
        if (!empty($res)) {
            foreach ($res as $m) {
                echo "<option value='" . $m->id . "'>" . $m->receipt_no . "( Rs." . ($m->amount + $m->tax) . " )" . "</option>";
            }
        }
    }

    public function getPlanRates($parms) {
      
        $rate = new \common\ebl\RateCalculation([
            'account_id' => $parms['id'],
            'bouquet_id' => $parms['plan_id'],
        ]);

        $r = $rate->rateDetails;
        if (!empty($r)) {
            echo json_encode($r);
            exit();
        }
        echo json_encode([]);
    }

    function getSelectData($model) {
        echo "<option value=''>Select options</option>";
        foreach ($model as $m) {
            echo "<option value='" . $m->id . "'>" . $m->name . "</option>";
        }
    }

    /*     * ***************************************** */

    public function actionRoad($id) {
        $model = Location::find()->where(['area_id' => $id, 'type' => C::LOCATION_ROAD])
                ->all();
        if (!empty($model)) {
            $this->getSelectData($model);
        }
    }

    public function actionBuilding($id) {
        $model = Location::find()->where(['road_id' => $id, 'type' => C::LOCATION_BUILDING])
                ->all();
        if (!empty($model)) {
            $this->getSelectData($model);
        }
    }

    public function actionPlan($id) {
        $model = \common\models\PlanMaster::getAssignedPlan($id, 2, C::PLAN_TYPE_BASE);
        if (!empty($model)) {
            $this->getSelectData($model);
        }
    }

    public function actionRates($operator_id, $id) {
        $model = \common\models\OperatorRates::getAssignedRates($operator_id, $id, 2);
        if (!empty($model)) {
            echo "<option value=''>Select options</option>";
            foreach ($model as $m) {
                echo "<option value='" . $m->rate_id . "'>" . $m->name . "</option>";
            }
        }
    }

}
