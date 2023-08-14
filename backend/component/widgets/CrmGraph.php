<?php

namespace backend\component\widgets;

use yii\helpers\Html;
use common\models\Complaint;
use common\models\ProspectSubscriber;
use common\ebl\Constants as C;
use yii\helpers\ArrayHelper;
use common\component\Utils as U;

class CrmGraph extends BaseWidgets {

    public $d = [];

    public function generateData() {
        $query = Complaint::find()->defaultCondition()->select(['status', 'count' => 'count(id)'])
                        ->groupBy(['status'])->asArray()->all();

        $cmpStatus = $label = [];
        foreach ($query as $q) {
            if (isset(C::COMPLAINT_STAGES_COLOR_CODE[$q['status']])) {
                $cmpStatus[$q['status']] = [
                    "color" => C::COMPLAINT_STAGES_COLOR_CODE[$q['status']]['hashcode'],
                    "cnt" => $q['count']
                ];

                $label[$q['status']] = [
                    "color" => C::COMPLAINT_STAGES_COLOR_CODE[$q['status']]['class'],
                    "hashcode" => C::COMPLAINT_STAGES_COLOR_CODE[$q['status']]['hashcode'],
                    "label" => C::COMPLAINT_STAGES_COLOR_CODE[$q['status']]['label'] . "(" . $q['count'] . ")"
                ];
            }
        }

        if (!empty($query)) {
            $this->d[] = [
                "title" => "Complaint Status-wise",
                "items" => $cmpStatus,
                "labels" => $label
            ];
        }

        $query = Complaint::find()->alias('a')->defaultCondition()->select(['category_id', 'count' => 'count(a.id)'])
                        ->joinWith(['category'])
                        ->groupBy(['category_id'])->asArray()->all();

        $cmpStatus = $labels = [];
        foreach ($query as $q) {
            $color = U::randonColorHash();
            $cmpStatus[$q['category_id']] = [
                "color" => $color,
                "cnt" => $q['count']
            ];

            $labels[$q['category_id']] = [
                "color" => $color,
                "hashcode" => $color,
                "label" => $q['category']['name'] . "(" . $q['count'] . ")"
            ];
        }
        if (!empty($query)) {
            $this->d[] = [
                "title" => "Complaint Category-wise",
                "items" => $cmpStatus,
                "labels" => $labels
            ];
        }

        $p = ProspectSubscriber::find()->defaultCondition()->select(['stages', 'count' => 'count(id)'])
                        ->groupBy(['stages'])->asArray()->all();

        $cmpStatus = $label = [];

        foreach ($p as $q) {
            if (isset(C::PROSPECT_STAGES_COLOR_CODE[$q['stages']])) {
                $cmpStatus[$q['stages']] = [
                    "color" => C::PROSPECT_STAGES_COLOR_CODE[$q['stages']]['hashcode'],
                    "cnt" => $q['count']
                ];

                $label[$q['stages']] = [
                    "color" => C::PROSPECT_STAGES_COLOR_CODE[$q['stages']]['class'],
                    "hashcode" => C::PROSPECT_STAGES_COLOR_CODE[$q['stages']]['hashcode'],
                    "label" => C::PROSPECT_STAGES_COLOR_CODE[$q['stages']]['label'] . "(" . $q['count'] . ")"
                ];
            }
        }

        if (!empty($p)) {
            $this->d[] = [
                "title" => "Prospect Details",
                "items" => $cmpStatus,
                "labels" => $label
            ];
        }
    }

    public function template() {
        $graph = [];

        foreach ($this->d as $d) {
            $donut = json_encode(["fill" => array_values(ArrayHelper::getColumn($d['items'], "color")), "innerRadius" => 50, "radius" => 80]);
            $title = Html::tag("h6", $d["title"], ["class" => "tx-inverse tx-14 mg-b-5"]);
            $bd = Html::tag("span", implode(",", array_values(ArrayHelper::getColumn($d['items'], "cnt"))), ["class" => "peity-donut", "data-peity" => $donut]);
            $bd = Html::tag("div", $bd, ["class" => "tx-center mg-y-20"]);
            $l = [];
            foreach ($d['labels'] as $lb) {
                $l[] = Html::tag("span", "", ["class" => "square-10 bg-" . $lb["color"] . " mg-r-5", "style" => "background-color:" . $lb["hashcode"]]) . $lb['label'];
            }
            $labels = Html::tag("div", implode("<br/>", $l), ["class" => "row"]);
            $labels = Html::tag("div", $labels, ["class" => "d-flex justify-content-between tx-12"]);

            $r = Html::tag("div", $title . $bd . $labels, ["class" => "card card-body rounded-0"]);
            $r = Html::tag("div", $r, ["class" => "col-sm-6 col-lg-3"]);
            $graph [] = $r;
        }

        $body = Html::tag("div", implode(" ", $graph), ['class' => "row no-gutters"]);
        $body = Html::tag("div", $body, ["class" => "card-body pd-x-25 pd-b-25 pd-t-0"]);

        $title = Html::tag("h6", "CRM Overview", ["class" => "card-title tx-uppercase tx-12 mg-b-0"]);
        $header = Html::tag("div", $title, ["class" => "card-header bg-transparent pd-x-25 pd-y-15 bd-b-0 d-flex justify-content-between align-items-center"]);
        return Html::tag("div", $header . $body, ['class' => "card shadow-base bd-0 mg-t-20"]);
    }

}
