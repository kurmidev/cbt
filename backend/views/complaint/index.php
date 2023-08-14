<?php

use yii\bootstrap\Html;
use common\component\Utils as U;
?>
<?= $this->render('@app/views/layouts/_header') ?>
<div class="bd-0 shadow-base widget-14 ht-100p pd-10">
    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header">Complaint Summary</div>
                <div class="card-body">
                    <?=
                    Html::ul(U::getComplaintSummary(), ['encode' => false, 'class' => 'list-group',
                        'item' => function ($item, $index) {
                            $text = "<i class='fa fa-cube tx-info mg-r-8'></i>";
                            $text .= "<span class='tx-inverse tx-medium'>" . $index . "</span>";
                            $text .= '<strong class="text-muted pull-right">' . $item . '</strong>';
                            return Html::tag('li', $text, ["class" => "list-group-item rounded-top-0"]);
                        }]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="card">
                <div class="card-header">
                    <div class="btn btn-group" role="group">
                        <?php foreach (U::getComplaintColorScheme() as $name => $color) { ?>
                            <span class="badge badge-<?= $color ?>"><?= ucwords($name) ?></span>&nbsp;
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body">
                    <?=
                    $this->render('complaint_list', [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>