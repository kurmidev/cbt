<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants;
use common\component\Utils;
use common\models\PlanMaster;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'TAX';
$this->params['links'] = [
    ['title' => 'Add New Plan', 'url' => \Yii::$app->urlManager->createUrl('plan/add-plan'), 'class' => 'fa fa-plus'],
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
        ['attribute' => 'plan_type', 'label' => 'Type',
            'content' => function($model) {
                return !empty($model->plan_type) ? Constants::LABEL_PLAN_TYPE[$model->plan_type] : "";
            },
            'filter' => Constants::LABEL_PLAN_TYPE,
        ],
        ['attribute' => 'billing_type', 'label' => 'Billing Type',
            'content' => function($model) {
                return Utils::getLabels(Constants::LABEL_BILLING_TYPE, $model->billing_type);
            },
            'filter' => Constants::LABEL_BILLING_TYPE,
        ],
        ['attribute' => 'status', 'label' => 'Status',
            'content' => function($model) {
                return Utils::getLabels(Constants::LABEL_STATUS, $model->status);
            },
            'filter' => Constants::LABEL_STATUS,
        ],
        'days',
        'actionOn',
        'actionBy',
        ['label' => 'Action',
            'content' => function ($data) {
                return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['plan/update-plan', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
            }
        ]
    ],
]);
?>
<?php Pjax::end(); ?>