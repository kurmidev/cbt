<?php

use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants;
use common\component\Utils;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'IP POOL';
$this->params['links'] = [
    ['title' => 'Add IP Pool', 'url' => \Yii::$app->urlManager->createUrl('plan/add-ippool'), 'class' => 'fa fa-plus'],
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
        'ipaddress',
        ['attribute' => 'type', 'label' => 'Type',
            'content' => function ($model) {
                return Utils::getLabels(Constants::POOL_TYPES, $model->type);
            },
            'filter' => Constants::POOL_TYPES,
        ],
        ['attribute' => 'status', 'label' => 'Status',
            'content' => function ($model) {
                return Utils::getLabels(Constants::LABEL_STATUS, $model->status);
            },
            'filter' => Constants::LABEL_STATUS,
        ],
        'actionOn',
        'actionBy',
    ],
]);
?>
<?php Pjax::end(); ?>