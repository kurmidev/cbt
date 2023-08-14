<?php

namespace backend\component\widgets;

use common\models\CustomerWallet;
use common\ebl\Constants as C;
use yii\helpers\Html;

class Collections extends \yii\base\Widget {

    public $todaysColl;
    public $last7Coll;
    public $monthColl;
    public $todayPend;
    public $last7Pend;
    public $monthPend;

    public function init() {
        parent::init();
        $this->generateData();
    }

    public function run() {
        return $this->template();
    }

    public function generateData() {
        $this->todaysColl = CustomerWallet::find()->defaultCondition()->andWhere(['trans_type' => C::TRANSACTION_TYPE_SUB_CREDIT])->andWhere(['between', 'added_on', date("Y-m-d 00:00:00"), date("Y-m-d 23:59:49")])->count();
        $this->last7Coll = CustomerWallet::find()->defaultCondition()->andWhere(['trans_type' => C::TRANSACTION_TYPE_SUB_CREDIT])->andWhere(['between', 'added_on', date("Y-m-d 00:00:00", strtotime("-8 days")), date("Y-m-d 23:59:49", strtotime("-1 days"))])->count();
        $this->monthColl = CustomerWallet::find()->defaultCondition()->andWhere(['trans_type' => C::TRANSACTION_TYPE_SUB_CREDIT])->andWhere(['between', 'added_on', date("Y-m-01 00:00:00"), date("Y-m-t 23:59:49")])->count();

        $sumCase = "ifnull((case when trans_type in (" . implode(",", C::TRANSACTION_TYPE_SUB_CREDIT) . ") then -1 else 1 end)* (amount+tax),0)";

        $this->todayPend = CustomerWallet::find()->defaultCondition()->andWhere(['trans_type' => C::TRANSACTION_TYPE_SUB_CREDIT])->andWhere(['between', 'added_on', date("Y-m-d 00:00:00"), date("Y-m-d 23:59:49")])->sum($sumCase);
        $this->last7Pend = CustomerWallet::find()->defaultCondition()->andWhere(['trans_type' => C::TRANSACTION_TYPE_SUB_CREDIT])->andWhere(['between', 'added_on', date("Y-m-d 00:00:00", strtotime("-8 days")), date("Y-m-d 23:59:49", strtotime("-1 days"))])->sum($sumCase);
        $this->monthPend = CustomerWallet::find()->defaultCondition()->andWhere(['trans_type' => C::TRANSACTION_TYPE_SUB_CREDIT])->andWhere(['between', 'added_on', date("Y-m-01 00:00:00"), date("Y-m-t 23:59:49")])->sum($sumCase);

        $this->todayPend = empty($this->todayPend) ? 0 : $this->todayPend;
        $this->last7Pend = empty($this->last7Pend) ? 0 : $this->last7Pend;
        $this->monthPend = empty($this->monthPend) ? 0 : $this->monthPend;
    }

    public function template() {
        $headerContent = Html::tag('h6', 'Collection Done', ['class' => 'card-title']);
        $header = Html::tag("div", $headerContent, ['class' => "card-header"]);

        $bodyData1 = [
            Html::tag('div', Html::tag('span', "Todays", ['class' => "tx-11"]) . Html::tag('h6', $this->todaysColl, ['class' => "tx-inverse"])),
            Html::tag('div', Html::tag('span', "Last 7 days", ['class' => "tx-11"]) . Html::tag('h6', $this->last7Coll, ['class' => "tx-inverse"])),
            Html::tag('div', Html::tag('span', "Current Month", ['class' => "tx-11"]) . Html::tag('h6', $this->monthColl, ['class' => "tx-inverse"])),
        ];

        $bodyData2 = [
            Html::tag('div', Html::tag('span', "Todays", ['class' => "tx-11"]) . Html::tag('h6', $this->todayPend, ['class' => "tx-inverse"])),
            Html::tag('div', Html::tag('span', "Last 7 days", ['class' => "tx-11"]) . Html::tag('h6', $this->last7Pend, ['class' => "tx-inverse"])),
            Html::tag('div', Html::tag('span', "Current Month", ['class' => "tx-11"]) . Html::tag('h6', $this->monthPend, ['class' => "tx-inverse"])),
        ];

        $headerContent1 = Html::tag('h6', 'Pending Collection', ['class' => 'card-title']);
        $header1 = Html::tag("div", $headerContent1, ['class' => "card-header"]);

        $body = Html::tag("div", implode("", $bodyData1), ['class' => "card-footer"]);
        $body1 = Html::tag("div", implode("", $bodyData2), ['class' => "card-footer"]);

        return Html::tag("div", $header . $body . $header1 . $body1, ['class' => "card"]);
    }

}
