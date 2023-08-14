<?php

namespace backend\component\widgets;

use common\models\CustomerAccountBouquet;
use common\ebl\Constants as C;
use yii\helpers\Html;

class TopPlans extends BaseWidgets {

    public $d;
    public $total;

    public function generateData() {
        $this->d = CustomerAccountBouquet::find()->cache(300)->setAlias('a')->defaultCondition("a")->active()
                        ->select(['a.bouquet_id','a.bouquet_name', 'cnt' => 'count(distinct a.account_id)'])
                        ->andWhere(['<', 'a.start_date', date("Y-m-d")])
                        ->andWhere(['>', 'a.end_date', date("Y-m-d")])
                        ->groupBy(['a.bouquet_id','a.bouquet_name'])->orderBy(['cnt' => SORT_DESC])
                        ->limit(10)->asArray()->all();

        $this->total = CustomerAccountBouquet::find()->cache(300)->setAlias('a')->defaultCondition("a")->active()  
                ->andWhere(['<', 'a.start_date', date("Y-m-d")])
                ->andWhere(['>', 'a.end_date', date("Y-m-d")])
                ->count();
    }

    public function template() {
        $title = Html::tag("h6", "Top 10 Bouquet", ['class' => "card-title tx-uppercase tx-12 mg-b-0"]);
        $header = Html::tag("div", $title, ['class' => "card-header bg-transparent pd-20"]);

        $list = [];
        foreach ($this->d as $plan) {
            $percent = floor(($plan['cnt'] / $this->total) * 100);
            $item = Html::tag("div", $plan['bouquet_name'], ['class' => "col-6 tx-14 tx-bold"]);
            $graph = Html::tag("div", $plan['cnt'], ['class' => "progress-bar bg-teal wd-" . $percent . "p lh-6 tx-12 font-weight-bold",
                        "role" => "progressbar", "aria-valuenow" => $percent,
                        "aria-valuemin" => "0", "aria-valuemax" => "100"]);
            //$graph .= Html::tag("div", $graph, ['class' => "progress rounded-0 mg-b-0"]);
            $graph = Html::tag("div", $graph, ['class' => "col-6"]);
            $list[] = Html::tag("div", $item . $graph, ['class' => "row align-items-center pd-4"]);
        }
        $link = Html::a("Click to view more", \Yii::$app->urlManager->createUrl(['report/plan-summary']));
        $footer = '<div class="card-footer tx-12 pd-y-15 bg-transparent">' . $link . '</div>';
        $body = Html::tag("div", implode(" ", $list), ['class' => "card-body"]);
        return Html::tag("div", $header . $body . $footer, ['class' => "card shadow-base bd-0"]);
    }

}
