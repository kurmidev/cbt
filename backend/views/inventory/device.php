<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants as C;
use common\component\Utils;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'ADD Device';
$this->params['links'] = [
    ['title' => 'Add Device', 'url' => \Yii::$app->urlManager->createUrl('inventory/add-device'), 'class' => 'fa fa-plus'],
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
        ['label' => 'Action',
            'content' => function ($data) {
                return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['inventory/update-device', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
            }
        ],
        'name',
        'code',
        "vendor.name:text:Vendor",
        "description:text:Description",
        [
            "attribute" => "amount",
            "content" => function ($model) {
                return Yii::$app->formatter->asCurrency($model->amount);
            }
        ],
//        [
//            "attribute" => "tax",
//            "content" => function ($model) {
//                return Yii::$app->formatter->asCurrency($model->tax);
//            }
//        ],
        ['attribute' => 'units', 'label' => 'Units',
            'content' => function ($model) {
                return Utils::getLabels(C::LABEL_MEASUREMENT, $model->units);
            },
            'filter' => C::LABEL_MEASUREMENT,
        ],
        ['attribute' => 'status', 'label' => 'Status',
            'content' => function ($model) {
                return Utils::getLabels(C::LABEL_STATUS, $model->status);
            },
            'filter' => C::LABEL_STATUS,
        ],
        'actionOn',
        'actionBy',
    ],
]);
?>
<?php Pjax::end(); ?>