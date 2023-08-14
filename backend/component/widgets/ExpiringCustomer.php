<?php

namespace backend\component\widgets;

use common\models\CustomerAccount;
use yii\helpers\Html;

class ExpiringCustomer extends BaseWidgets {

    public $d;

    public function generateData() {
        $this->d = CustomerAccount::find()->defaultCondition()
                        ->andWhere(['between', 'end_date', date("Y-m-d", strtotime("+1days")), date("Y-m-d", strtotime("+7day"))])
                        ->select(['end_date', 'cnt' => 'count(distinct id)'])->groupBy(['end_date'])->asArray()->all();
    }

    public function template() {
        $title = Html::tag("h6", "Expring in next 7 days.", ['class' => "card-title tx-uppercase tx-12 mg-b-0"]);
        $header = Html::tag("div", $title, ['class' => "card-header bg-transparent pd-20"]);

        $list = '<table class="table table-responsive mg-b-0 tx-12">'
                . '<thead>'
                . '<tr>'
                . '<th>Date</th>'
                . '<th></th>'
                . '<th>Count</th>'
                . '</tr></thead><tbody>';
        foreach ($this->d as $s) {
            $a = Html::a($s['cnt'], \Yii::$app->urlManager->createUrl(['account/index', 'CustomerAccountSearch[next7Days]' => 1], ["class" => "tx-danger"]));
            $list .= '<tr>'
                    . '<td>' . $s['end_date'] . '</td>'
                    . '<td>&nbsp;</td>'
                    . '<td>' . $a . '</td>'
                    . '</tr>';
        }
        $link = ''; //Html::a("Click to view more", \Yii::$app->urlManager->createUrl(['report/fran-customer']));
        $list .= '</tbody></table><div class="card-footer tx-12 pd-y-15 bg-transparent">' . $link . '</div>';
        $body = Html::tag("div", $list, ['class' => "card-body"]);
        return Html::tag("div", $header . $body, ['class' => "card shadow-base bd-0"]);
    }

}
