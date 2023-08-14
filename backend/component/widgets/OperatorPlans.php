<?php

namespace backend\component\widgets;

use common\models\CustomerAccountBouquet;
use common\ebl\Constants as C;
use yii\helpers\Html;

class OperatorPlans extends BaseWidgets {

    public $d;
    public $total;

    public function generateData() {
        $this->d = CustomerAccountBouquet::find()->cache(300)->setAlias('a')->defaultCondition()->joinWith([ 'operator'])
                        ->select(['a.operator_id',
                            'active' => "sum(case when a.end_date>='" . date("Y-m-d") . "' and a.status=" . C::STATUS_ACTIVE . " then 1 else 0 end)",
                            'inactive' => "sum(case when a.status in (" . C::STATUS_INACTIVE . "," . C::STATUS_INACTIVATE_REFUND . ") then 1 else 0 end)",
                            'expiry' => "sum(case when a.end_date<'" . date("Y-m-d") . "' and a.status=" . C::STATUS_EXPIRED . " then 1 else 0 end)"
                        ])
                        ->groupBy(['a.operator_id'])->orderBy(['active' => SORT_DESC])->limit(10)->asArray()->all();
    }

    public function template() {

        $title = Html::tag("h6", "Franchise Vs Customer", ['class' => "card-title tx-uppercase tx-12 mg-b-0"]);
        $header = Html::tag("div", $title, ['class' => "card-header bg-transparent pd-20"]);

        $list = '<table class="table table-responsive mg-b-0 tx-12">'
                . '<thead>'
                . '<tr>'
                . '<th>Franchise</th>'
                . '<th>Code</th>'
                . '<th>Active</th>'
                . '<th>In Active</th>'
                . '<th>Expired</th>'
                . '</tr></thead><tbody>';
        foreach ($this->d as $s) {
            $list .= '<tr>'
                    . '<td>' . $s['operator']['name'] . '</td>'
                    . '<td>' . $s['operator']['code'] . '</td>'
                    . '<td class="tx-success">' . $s['active'] . '</td>'
                    . '<td class="tx-warning">' . $s['inactive'] . '</td>'
                    . '<td class="tx-danger">' . $s['expiry'] . '</td>'
                    . '</tr>';
        }
        $link = Html::a("Click to view more", \Yii::$app->urlManager->createUrl(['report/fran-customer']));
        $list .= '</tbody></table><div class="card-footer tx-12 pd-y-15 bg-transparent">' . $link . '</div>';

        $body = Html::tag("div", $list, ['class' => "card-body"]);
        return Html::tag("div", $header . $body, ['class' => "card shadow-base bd-0"]);
    }

}
