<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants as C;
use common\component\Utils;
use common\models\Bouquet;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Bouquet';
$this->params['links'] = [
    ['title' => 'Add New Bouquet', 'url' => \Yii::$app->urlManager->createUrl('plan/add-bouquet'), 'class' => 'fa fa-plus'],
    ['title' => 'Assign Bouquet', 'url' => \Yii::$app->urlManager->createUrl('plan/assign-bouquet'), 'class' => 'fa fa-plus-circle'],
    ['title' => 'De-Assign Bouquet', 'url' => \Yii::$app->urlManager->createUrl('plan/deassign-bouquet'), 'class' => 'fa fa-minus-circle'],
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
        ['attribute' => 'type', 'label' => 'Type',
            'content' => function ($model) {
                return !empty($model->type) ? C::LABEL_PLAN_TYPE[$model->type] : "";
            },
            'filter' => C::LABEL_PLAN_TYPE,
        ],
        ['attribute' => 'bill_type', 'label' => 'Billing Type',
            'content' => function ($model) {
                return Utils::getLabels(C::LABEL_BILLING_TYPE, $model->bill_type);
            },
            'filter' => C::LABEL_BILLING_TYPE,
        ],
        ['attribute' => 'status', 'label' => 'Status',
            'content' => function ($model) {
                return Utils::getLabels(C::LABEL_STATUS, $model->status);
            },
            'filter' => C::LABEL_STATUS,
        ],
        ['attribute' => 'is_online', 'label' => 'Is Online',
            'content' => function ($model) {
                return Utils::getLabels([C::STATUS_INACTIVE => 'No', C::STATUS_ACTIVE => 'Yes',], $model->is_online);
            },
            'filter' => [C::STATUS_INACTIVE => 'No', C::STATUS_ACTIVE => 'Yes',],
        ],
        'days',
        'actionOn',
        'actionBy',
        ['label' => 'Action',
            'content' => function ($data) {
                return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['plan/update-bouquet', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
            }
        ]
    ],
]);
?>
<?php Pjax::end(); ?>