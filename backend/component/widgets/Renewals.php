<?php

namespace backend\component\widgets;

use common\ebl\Constants as C;
use yii\helpers\Html;
use common\models\CustomerAccountBouquet;
use common\models\CustomerAccount;

class Renewals extends \yii\base\Widget {

    public $todaysRenewals;
    public $last7DaysRenewals;
    public $thisMonthRenewals;
    public $todaysNewConnection;
    public $last7DaysNewConnection;
    public $thisMonthNewConnection;

    public function init() {
        parent::init();
        $this->generateData();
    }

    public function run() {
        return $this->template();
    }

    public function generateData() {
        $this->todaysRenewals = CustomerAccountBouquet::find()->defaultCondition()->andWhere(['between', 'added_on', date("Y-m-d 00:00:00"), date("Y-m-d 23:59:49")])->count();
        $this->last7DaysRenewals = CustomerAccountBouquet::find()->defaultCondition()->andWhere(['between', 'added_on', date("Y-m-d 00:00:00", strtotime("-8 days")), date("Y-m-d 23:59:49", strtotime("-1 days"))])->count();
        $this->thisMonthRenewals = CustomerAccountBouquet::find()->defaultCondition()->andWhere(['between', 'added_on', date("Y-m-01 00:00:00"), date("Y-m-t 23:59:49")])->count();

        $this->todaysNewConnection = CustomerAccount::find()->defaultCondition()->andWhere(['between', 'added_on', date("Y-m-d 00:00:00"), date("Y-m-d 23:59:49")])->count();
        $this->last7DaysNewConnection = CustomerAccount::find()->defaultCondition()->andWhere(['between', 'added_on', date("Y-m-d 00:00:00", strtotime("-8 days")), date("Y-m-d 23:59:49", strtotime("-1 days"))])->count();
        $this->thisMonthNewConnection = CustomerAccount::find()->defaultCondition()->andWhere(['between', 'added_on', date("Y-m-01 00:00:00"), date("Y-m-t 23:59:49")])->count();
    }

    public function template() {
        $headerContent = Html::tag('h6', 'Renewals Details', ['class' => 'card-title']);
        $header = Html::tag("div", $headerContent, ['class' => "card-header"]);

        $todaysRenewal = Html::a($this->todaysRenewals, \Yii::$app->urlManager->createUrl(['report/renewal', "CustomerAccountBouquetSearch[todaysRenewals]" => 1]), ['class' => "tx-inverse", "target" => "_blank"]);
        $last7DaysRenewals = Html::a($this->last7DaysRenewals, \Yii::$app->urlManager->createUrl(['report/renewal', "CustomerAccountBouquetSearch[last7DaysRenewals]" => 1]), ['class' => "tx-inverse", "target" => "_blank"]);
        $thisMonthRenewals = Html::a($this->thisMonthRenewals, \Yii::$app->urlManager->createUrl(['report/renewal', "CustomerAccountBouquetSearch[thisMonthRenewals]" => 1]), ['class' => "tx-inverse", "target" => "_blank"]);

        $bodyData1 = [
            Html::tag('div', Html::tag('span', "Todays", ['class' => "tx-11"]) . Html::tag('h6', $todaysRenewal, ['class' => "tx-inverse"])),
            Html::tag('div', Html::tag('span', "Last 7 days", ['class' => "tx-11"]) . Html::tag('h6', $last7DaysRenewals, ['class' => "tx-inverse"])),
            Html::tag('div', Html::tag('span', "Current Month", ['class' => "tx-11"]) . Html::tag('h6', $thisMonthRenewals, ['class' => "tx-inverse"])),
        ];

        $todaysConnection = Html::a($this->todaysNewConnection, \Yii::$app->urlManager->createUrl(['account/index', "CustomerAccountSearch[todays]" => 1]), ['class' => "tx-inverse", "target" => "_blank"]);
        $last7DaysConnection = Html::a($this->last7DaysNewConnection, \Yii::$app->urlManager->createUrl(['account/index', "CustomerAccountSearch[last7Days]" => 1]), ['class' => "tx-inverse", "target" => "_blank"]);
        $thisMonthConnection = Html::a($this->thisMonthNewConnection, \Yii::$app->urlManager->createUrl(['account/index', "CustomerAccountSearch[thisMonth]" => 1]), ['class' => "tx-inverse", "target" => "_blank"]);

        $bodyData2 = [
            Html::tag('div', Html::tag('span', "Todays", ['class' => "tx-11"]) . Html::tag('h6', $todaysConnection, ['class' => "tx-inverse"])),
            Html::tag('div', Html::tag('span', "Last 7 days", ['class' => "tx-11"]) . Html::tag('h6', $last7DaysConnection, ['class' => "tx-inverse"])),
            Html::tag('div', Html::tag('span', "Current Month", ['class' => "tx-11"]) . Html::tag('h6', $thisMonthConnection, ['class' => "tx-inverse"])),
        ];

        $headerContent1 = Html::tag('h6', 'New Connections', ['class' => 'card-title']);
        $header1 = Html::tag("div", $headerContent1, ['class' => "card-header"]);

        $body = Html::tag("div", implode("", $bodyData1), ['class' => "card-footer"]);
        $body1 = Html::tag("div", implode("", $bodyData2), ['class' => "card-footer"]);

        return Html::tag("div", $header . $body . $header1 . $body1, ['class' => "card"]);
    }

}
