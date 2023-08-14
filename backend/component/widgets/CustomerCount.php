<?php

namespace backend\component\widgets;

use common\models\CustomerAccount;
use common\models\RadiusAccounting;
use common\ebl\Constants as C;
use yii\helpers\Html;

class CustomerCount extends \yii\base\Widget {

    public $activeCnt;
    public $inactiveCnt;
    public $expiryCnt;
    public $totalCnt;
    public $onlineActive;
    public $onlineInActive;
    public $onlineExpiry;
    public $onlineTotal;

    public function init() {
        parent::init();
        $this->generateData();
    }

    public function run() {
        return $this->template();
    }

    public function generateData() {
        $model = CustomerAccount::find()->defaultCondition()
                        ->select(["status", "cnt" => "count(distinct username)"])
                        ->groupBy(['status'])->indexBy('status')->asArray()->all();

        $this->totalCnt = array_sum(\yii\helpers\ArrayHelper::getColumn($model, 'cnt'));
        $this->activeCnt = !empty($model[C::STATUS_ACTIVE]) ? $model[C::STATUS_ACTIVE]['cnt'] : 0;
        $this->expiryCnt = !empty($model[C::STATUS_EXPIRED]) ? $model[C::STATUS_EXPIRED]['cnt'] : 0;
        unset($model[C::STATUS_EXPIRED], $model[C::STATUS_ACTIVE]);
        $this->inactiveCnt = array_sum(\yii\helpers\ArrayHelper::getColumn($model, 'cnt'));

        $model = CustomerAccount::find()->alias('a')->defaultCondition()->innerJoinWith(['radiusAccounting b'])
                        ->select(["a.status", "cnt" => "count(distinct a.username)"])
                        ->andWhere(['b.acctstoptime' => null])
                        ->groupBy(['a.status'])->indexBy('status')->asArray()->all();

        $this->onlineTotal = array_sum(\yii\helpers\ArrayHelper::getColumn($model, 'cnt'));
        $this->onlineActive = !empty($model[C::STATUS_ACTIVE]) ? $model[C::STATUS_ACTIVE]['cnt'] : 0;
        $this->onlineExpiry = !empty($model[C::STATUS_EXPIRED]) ? $model[C::STATUS_EXPIRED]['cnt'] : 0;
        unset($model[C::STATUS_EXPIRED], $model[C::STATUS_ACTIVE]);
        $this->onlineInActive = array_sum(\yii\helpers\ArrayHelper::getColumn($model, 'cnt'));
    }

    public function template() {
        $headerContent = Html::tag('h6', 'Customer Detail', ['class' => 'card-title']);
        $header = Html::tag("div", $headerContent, ['class' => "card-header"]);

        $activeUrl = Html::a($this->activeCnt, \Yii::$app->urlManager->createUrl(['report/active-customer']), ['class' => "tx-success", "target" => "_blank"]);
        $inactiveUrl = Html::a($this->inactiveCnt, \Yii::$app->urlManager->createUrl(['report/inactive-customer']), ['class' => "tx-warning", "target" => "_blank"]);
        $expiredUrl = Html::a($this->expiryCnt, \Yii::$app->urlManager->createUrl(['report/expired-customer']), ['class' => "tx-danger", "target" => "_blank"]);
        $totalUrl = Html::a($this->totalCnt, \Yii::$app->urlManager->createUrl(['account/index']), ['class' => "tx-inverse", "target" => "_blank"]);

        $bodyData1 = [
            Html::tag('div', Html::tag('span', "Active", ['class' => "tx-11"]) . Html::tag('h6', $activeUrl, ['class' => "tx-success"])),
            Html::tag('div', Html::tag('span', "In Active", ['class' => "tx-11"]) . Html::tag('h6', $inactiveUrl, ['class' => "tx-warning"])),
            Html::tag('div', Html::tag('span', "Expired", ['class' => "tx-11"]) . Html::tag('h6', $expiredUrl, ['class' => "tx-danger"])),
            Html::tag('div', Html::tag('span', "Total", ['class' => "tx-11"]) . Html::tag('h6', $totalUrl, ['class' => "tx-inverse"])),
        ];

        $bodyData2 = [
            Html::tag('div', Html::tag('span', "Active", ['class' => "tx-11"]) . Html::tag('h6', $this->onlineActive, ['class' => "tx-success"])),
            Html::tag('div', Html::tag('span', "In Active", ['class' => "tx-11"]) . Html::tag('h6', $this->onlineInActive, ['class' => "tx-warning"])),
            Html::tag('div', Html::tag('span', "Expiry", ['class' => "tx-11"]) . Html::tag('h6', $this->onlineExpiry, ['class' => "tx-danger"])),
            Html::tag('div', Html::tag('span', "Total", ['class' => "tx-11"]) . Html::tag('h6', $this->onlineTotal, ['class' => "tx-inverse"])),
        ];

        $headerContent1 = Html::tag('h6', 'Online Customer', ['class' => 'card-title']);
        $header1 = Html::tag("div", $headerContent1, ['class' => "card-header"]);

        $body = Html::tag("div", implode("", $bodyData1), ['class' => "card-footer"]);
        $body1 = Html::tag("div", implode("", $bodyData2), ['class' => "card-footer"]);

        return Html::tag("div", $header . $body . $header1 . $body1, ['class' => "card"]);
    }

}
