<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants as C;

Pjax::begin();
?>
<?=

ImsGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'rowOptions' => function ($model, $index, $widget, $grid) {
        return ['style' => "color:" . C::COMPLAINT_STAGES_COLOR_CODE[$model->stages]['hashcode'] . ";"];
    },
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['label' => 'Action',
            'content' => function ($data) {
                if ($data['stages'] != C::COMPLAINT_CLOSED)
                    return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['complaint/process-complaint', 'id' => $data['id']]), ['title' => 'Process ' . $data['ticketno'], 'class' => 'btn btn-primary-alt']);

                if ($data['stages'] == C::COMPLAINT_CLOSED)
                    return Html::a(Html::tag('span', '', ['class' => 'fa fa-bars']), \Yii::$app->urlManager->createUrl(['complaint/view-complaint', 'id' => $data['id']]), ['title' => 'Process ' . $data['ticketno'], 'class' => 'btn btn-primary-alt']);
            }
        ],
        'ticketno',
        ['attribute' => 'stages', 'label' => 'Stage',
            'content' => function ($model) {
                return !empty(C::COMPLAINT_SATGES[$model->stages]) ? C::COMPLAINT_SATGES[$model->stages] : null;
            },
            'filter' => C::COMPLAINT_SATGES,
        ],
        'username',
        'customer.name:text:Name',
        'customer.mobile_no:text:Mobile No.',
        'customer.phone_no:text:Phone No.',
        'category.name:text:Category',
        'opening:text:Query',
        'closing:text:Resolution',
        'currentlyAssignedUser.name:text:Assigned To',
        'actionOn',
        'actionBy',
    ],
]);
?>
<?php Pjax::end(); ?>