<?php

namespace backend\component\widgets;

use common\models\CustomerAccountBouquet;
use common\ebl\Constants as C;
use yii\helpers\Html;

class PlanSummary extends BaseWidgets {

    public $d;

    public function generateData() {
        $this->d = CustomerAccountBouquet::find()->cache(300)->setAlias('a')->defaultCondition()->joinWith(['bouquet'])
                        ->select(['a.bouquet_id',
                            'activecnt' => 'sum(case when a.status=' . C::STATUS_ACTIVE . ' then 1 else 0 end)',
                            'inactivecnt' => 'sum(case when a.status not in (' . implode(",", [C::STATUS_ACTIVE, C::STATUS_EXPIRED]) . ') then 1 else 0 end)',
                            'expiry' => 'sum(case when a.status=' . C::STATUS_EXPIRED . ' then 1 else 0 end)',
                        ])
                        ->andWhere(['<', 'a.start_date', date("Y-m-d")])->andWhere(['>', 'a.end_date', date("Y-m-d")])
                        ->groupBy(['a.bouquet_id'])->limit(10)->asArray()->all();
    }

    public function template() {
        $title = Html::tag("h6", "Bouquet Summary", ['class' => "card-title tx-uppercase tx-12 mg-b-0"]);
        $header = Html::tag("div", $title, ['class' => "card-header bg-transparent pd-20"]);

        $list = '<table class="table table-responsive mg-b-0 tx-12">'
                . '<thead>'
                . '<tr>'
                . '<th>Bouquet</th>'
                . '<th>Active</th>'
                . '<th>In Active</th>'
                . '<th>Expired</th>'
                . '</tr></thead><tbody>';
        foreach ($this->d as $plan) {
            $list .= '<tr>'
                    . '<td>' . $plan['bouquet']['name'] . '</td>'
                    . '<td class="tx-success">' . $plan['activecnt'] . '</td>'
                    . '<td class="tx-warning">' . $plan['inactivecnt'] . '</td>'
                    . '<td class="tx-danger">' . $plan['expiry'] . '</td>'
                    . '</tr>';
        }
        $link = Html::a("Click to view more", \Yii::$app->urlManager->createUrl(['report/plan-summary']));
        $list .= '</tbody></table><div class="card-footer tx-12 pd-y-15 bg-transparent">'.$link.'</div>';

        $body = Html::tag("div", $list, ['class' => "card-body"]);
        return Html::tag("div", $header . $body, ['class' => "card shadow-base bd-0"]);
    }

}
