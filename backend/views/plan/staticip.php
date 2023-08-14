<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants;
use common\component\Utils;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Static Ip Policy';
$this->params['links'] = [
    ['title' => 'Add New Static Ip Policy', 'url' => \Yii::$app->urlManager->createUrl('plan/add-staticip'), 'class' => 'fa fa-plus'],
    ['title' => 'Assign Static Ip Policy', 'url' => \Yii::$app->urlManager->createUrl('plan/assign-staticip'), 'class' => 'fa fa-cog'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_header') ?>
<?php Pjax::begin(); ?>
<?=

ImsGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'rowOptions' => function ($model, $index, $widget, $grid) {
        if ($model->status == Constants::STATUS_INACTIVE) {
            return ['style' => 'color:#a94442; background-color:#f2dede;'];
        }
    },
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'code',
        'months',
        'days',
        ['attribute' => 'is_refundable', 'label' => 'Refundable',
            'content' => function($model) {
                return $model->is_refundable ? 'Yes' : 'No';
            },
        ],
        'amount',
        'amount_tax',
        'mrp',
        'mrp_tax',
        ['attribute' => 'status', 'label' => 'Status',
            'content' => function($model) {
                return Utils::getLabels(Constants::LABEL_STATUS, $model->status);
            },
            'filter' => Constants::LABEL_STATUS,
        ],
        'actionOn',
        'actionBy',
        ['label' => 'Action',
            'content' => function ($data) {
                return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['plan/update-staticip', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
            }
        ]
    ],
]);
?>
<?php Pjax::end(); ?>