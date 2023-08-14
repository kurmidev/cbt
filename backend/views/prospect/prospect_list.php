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
        return ['style' => "color:" . C::PROSPECT_STAGES_COLOR_CODE[$model->stages]['hashcode'] . ";"];
    },
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['label' => 'Action',
            'content' => function ($data) {
                if ($data['stages'] !== C::PROSPECT_CALL_CLOSED)
                    return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['prospect/process-request', 'id' => $data['id']]), ['title' => 'Process ' . $data['name'], 'class' => 'btn btn-primary-alt']);
            }
        ],
        'ticket_no',
        ['attribute' => 'stages', 'label' => 'Stage',
            'content' => function($model) {
                return !empty(C::PROSPECT_SATGES[$model->stages]) ? C::PROSPECT_SATGES[$model->stages] : null;
            },
            'filter' => C::PROSPECT_SATGES,
        ],
        'name',
        'mobile_no',
        ['attribute' => 'mobile_no', 'label' => 'Mobile No<br>Phone No',
            'content' => function($model) {
                return $model->mobile_no . '<br/>' . $model->phone_no;
            },
        ],
        'phone_no',
        'address',
        'area_name',
        ['attribute' => 'connection_type', 'label' => 'Connection Type',
            'content' => function($model) {
                return !empty(C::LABEL_CONNECTION_TYPE[$model->connection_type]) ? C::LABEL_CONNECTION_TYPE[$model->connection_type] : null;
            },
            'filter' => C::LABEL_CONNECTION_TYPE,
        ],
        'actionOn',
        'actionBy',
    ],
]);
?>
<?php Pjax::end(); ?>