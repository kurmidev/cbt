<?php

namespace backend\component\widgets;

use common\models\ProspectSubscriber;
use common\ebl\Constants as C;
use yii\helpers\Html;

class Crm extends \yii\base\Widget {

    public $prospectVerify;
    public $prospectInstall;
    public $prospectFinal;
    public $prospectClosed;
    public $openComplaint;
    public $closedComplaint;

    public function init() {
        parent::init();
        $this->generateData();
    }

    public function run() {
        return $this->template();
    }

    public function generateData() {
        $model = ProspectSubscriber::find()->cache()->defaultCondition()->select(['stages', 'cnt' => 'count(id)'])
                        ->groupBy(['stages'])->indexBy('stages')->asArray()->all();
        $this->prospectVerify = !empty($model[C::PROSPECT_VERIFY]) ? $model[C::PROSPECT_VERIFY]['cnt'] : 0;
        $this->prospectInstall = !empty($model[C::PROSPECT_INSTALLATION]) ? $model[C::PROSPECT_INSTALLATION]['cnt'] : 0;
        $this->prospectFinal = !empty($model[C::PROSPECT_FINAL_VERIFY]) ? $model[C::PROSPECT_FINAL_VERIFY]['cnt'] : 0;
        $this->prospectClosed = !empty($model[C::PROSPECT_CALL_CLOSED]) ? $model[C::PROSPECT_CALL_CLOSED]['cnt'] : 0;

        $model = \common\models\Complaint::find()->cache()->defaultCondition()->select(['stages', 'cnt' => 'count(id)'])
                        ->groupBy(['stages'])->indexBy('stages')->asArray()->all();
        $this->openComplaint = !empty($model[C::COMPLAINT_PENDING]) ? $model[C::COMPLAINT_PENDING]['cnt'] : 0;
        $this->closedComplaint = !empty($model[C::COMPLAINT_CLOSED]) ? $model[C::COMPLAINT_CLOSED]['cnt'] : 0;
    }

    public function template() {
        $headerContent = Html::tag('h6', 'Complaint Details', ['class' => 'card-title']);
        $header = Html::tag("div", $headerContent, ['class' => "card-header"]);

        $bodyData1 = [
            Html::tag('div', Html::tag('span', "Pending", ['class' => "tx-11"]) . Html::tag('h6', $this->openComplaint, ['class' => "tx-danger"])),
            Html::tag('div', Html::tag('span', "Closed", ['class' => "tx-11"]) . Html::tag('h6', $this->closedComplaint, ['class' => "tx-success"])),
        ];

        $bodyData2 = [
            Html::tag('div', Html::tag('span', "Verifiy", ['class' => "tx-11"]) . Html::tag('h6', $this->prospectVerify, ['class' => "tx-danger"])),
            Html::tag('div', Html::tag('span', "Install", ['class' => "tx-11"]) . Html::tag('h6', $this->prospectInstall, ['class' => "tx-warning"])),
            Html::tag('div', Html::tag('span', "Final Verify", ['class' => "tx-11"]) . Html::tag('h6', $this->prospectFinal, ['class' => "tx-primary"])),
            Html::tag('div', Html::tag('span', "Closed", ['class' => "tx-11"]) . Html::tag('h6', $this->prospectClosed, ['class' => "tx-success"])),
        ];

        $headerContent1 = Html::tag('h6', 'Prospect Details', ['class' => 'card-title']);
        $header1 = Html::tag("div", $headerContent1, ['class' => "card-header"]);

        $body = Html::tag("div", implode("", $bodyData1), ['class' => "card-footer"]);
        $body1 = Html::tag("div", implode("", $bodyData2), ['class' => "card-footer"]);

        return Html::tag("div", $header . $body . $header1 . $body1, ['class' => "card"]);
    }

}
