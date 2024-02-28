<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants as C;
use common\component\Utils as U;


/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Broadcaster';
$this->params['links'] = [
    ['title' => 'Add New Broadcaster', 'url' => \Yii::$app->urlManager->createUrl('services/add-broadcaster'), 'class' => 'fa fa-plus'],
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
        if ($model->status == C::STATUS_INACTIVE) {
            return ['style' => 'color:#a94442; background-color:#f2dede;'];
        }
    },
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'code',
        'contact_no',
        'address',
        ['attribute' => 'status', 'label' => 'Status',
            'content' => function($model) {
                return U::getLabels(C::LABEL_STATUS, $model->status);
            },
            'filter' => C::LABEL_STATUS,
        ],
        'actionOn',
        'actionBy',
        ['label' => 'Action',
            'content' => function ($data) {
                return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['services/update-broadcaster', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
            }
        ]
    ],
]);
?>
<?php Pjax::end(); ?>