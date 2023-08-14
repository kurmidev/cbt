<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use common\component\ImsGridView;
use common\component\Utils as U;
?>

<div class="card">
    <div class="row pd-10 mg-10">
        <div class="col-8 col-md-8 col-lg-8 col-sm-6">    
            <strong>Wallet Transactions Details</strong>
        </div>
        <div class="col-4 col-md-4 col-lg-4 col-sm-6">    
            <?=
            Html::a('ADD CREDIT', \Yii::$app->urlManager->createUrl(["operator/recharge-$actionUrl", 'id' => $id]), ['class' => 'btn btn-outline-teal pull-right pd-10', 'title' => "Add Credit"])
            ?>
        </div>
    </div>

    <?php Pjax::begin(['id' => 'opt-wallet-list']); ?>

    <?=
    ImsGridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'receipt_no',
            [
                'attribute' => 'amount',
                'content' => function($data) {
                    return $data['amount'];
                }
            ],
            [
                'attribute' => 'tax',
                'content' => function($data) {
                    return $data['tax'];
                }
            ],
            [
                'attribute' => 'type',
                'content' => function($model) {
                    return U::getLabels(U::optTransactionLabel(), $model->trans_type);
                },
                'filter' => U::optTransactionLabel(),
            ],
            [
                'label' => "Instrument No",
                'attribute' => 'meta_data',
                'content' => function($model) {
                    return !empty($model->meta_data['instrument_nos']) ? $model->meta_data['instrument_nos'] : "";
                },
                'filter' => U::optTransactionLabel(),
            ],
            [
                'label' => "Instrument Date",
                'attribute' => 'meta_data',
                'content' => function($model) {
                    return !empty($model->meta_data['instrument_date']) ? $model->meta_data['instrument_date'] : "";
                },
                'filter' => U::optTransactionLabel(),
            ],
            [
                'label' => "Instrument Name",
                'attribute' => 'meta_data',
                'content' => function($model) {
                    return !empty($model->meta_data['instrument_name']) ? $model->meta_data['instrument_name'] : "";
                },
                'filter' => U::optTransactionLabel(),
            ],
            [
                'label' => "Balance",
                'content' => function($data) {
                    return $data['balance'];
                }
            ],
            [
                'attribute' => 'actionOn', 'label' => 'Trans Date',
                'content' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->actionOn, 'php:d M Y H:i');
                }
            ],
            [
                'attribute' => 'actiondoneby', 'label' => 'Trans By',
                'content' => function ($model) {
                    return $model->actionBy;
                }
            ],
        ],
    ]);
    ?>
    <?php Pjax::end() ?>
</div>

