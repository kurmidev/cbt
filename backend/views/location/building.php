<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants;
use common\component\Utils;
use common\models\Location;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Building';
$this->params['links'] = [
    ['title' => 'Add New Building', 'url' => \Yii::$app->urlManager->createUrl('location/add-building'), 'class' => 'fa fa-plus'],
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
        ['attribute' => 'road_id', 'label' => 'Road',
            'content' => function($model) {
                return !empty($model->road) ? $model->road->name : null;
            },
            'filter' => \yii\helpers\ArrayHelper::map(Location::find()->where(['type' => Constants::LOCATION_ROAD])->all(), 'id', 'name'),
        ],
        ['attribute' => 'area_id', 'label' => 'Area',
            'content' => function($model) {
                return !empty($model->area) ? $model->area->name : null;
            },
            'filter' => \yii\helpers\ArrayHelper::map(Location::find()->where(['type' => Constants::LOCATION_AREA])->all(), 'id', 'name'),
        ],
        ['attribute' => 'city_id', 'label' => 'City',
            'content' => function($model) {
                return !empty($model->city) ? $model->city->name : null;
            },
            'filter' => \yii\helpers\ArrayHelper::map(Location::find()->where(['type' => Constants::LOCATION_CITY])->all(), 'id', 'name'),
        ],
        ['attribute' => 'state_id', 'label' => 'State',
            'content' => function($model) {
                return !empty($model->state) ? $model->state->name : null;
            },
            'filter' => \yii\helpers\ArrayHelper::map(Location::find()->where(['type' => Constants::LOCATION_STATE])->all(), 'id', 'name'),
        ],
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
                return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['location/update-building', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
            }
        ]
    ],
]);
?>
<?php Pjax::end(); ?>