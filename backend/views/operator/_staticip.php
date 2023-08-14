<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use common\component\ImsGridView;
use common\component\Utils as U;
use common\ebl\Constants as C;
?>

<div class="card">
    <div class="row pd-10 mg-10">
        <div class="col-8 col-md-8 col-lg-8 col-sm-6">    
            <strong>Alloted Static IP Plans</strong>
        </div>
        <div class="col-4 col-md-4 col-lg-4 col-sm-6">    
            <?=
            Html::a('CHANGE MRP', \Yii::$app->urlManager->createUrl(["operator/add-static-mrp", 'id' => $id]), ['class' => 'btn btn-outline-teal pd-10 mg-10  pull-right', 'title' => "Add MRP"])
            ?>
        </div>
    </div>

    <?php Pjax::begin(['id' => 'assigned-static-list']); ?>

    <?=
    ImsGridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            "staticip.name",
            "staticip.code",
            "staticip.days",
            [
                "header" => 'Price(A)',
                'content' => function ($model) {
                    return $model->amount;
                }
            ],
            [
                "header" => 'Tax(B)',
                'content' => function ($model) {
                    return $model->tax;
                }
            ],
            [
                "header" => 'Total(A+B)',
                'content' => function ($model) {
                    return ($model->amount + $model->tax);
                }
            ],
            [
                "header" => 'MRP Price(A)',
                'content' => function ($model) {
                    return $model->mrp;
                }
            ],
            [
                "header" => 'MRP Tax(B)',
                'content' => function ($model) {
                    return $model->mrp_tax;
                }
            ],
            [
                "header" => 'MRP(A+B)',
                'content' => function ($model) {
                    return ($model->mrp + $model->mrp_tax);
                }
            ],
        ],
    ]);
    ?>
    <?php Pjax::end() ?>
</div>
