<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants;
use common\component\Utils;
use common\models\TaxMaster;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'TAX';
$this->params['links'] = [
        ['title' => 'Add New TAX', 'url' => \Yii::$app->urlManager->createUrl('config/add-tax'), 'class' => 'fa fa-plus'],
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
            ['attribute' => 'type', 'label' => 'Type',
            'content' => function($model) {
                return !empty($model->type) ? Constants::$LABEL_TAX_TYPE[$model->type] : "";
            },
            'filter' => Constants::$LABEL_TAX_TYPE,
        ],
        'value',
            ['attribute' => 'applicable_on', 'label' => 'Applicable On',
            'content' => function($model) {
                return $model->applicableLabel;
            },
            'filter' => Constants::LABEL_TAX_APPLICABLE_ON,
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
                return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['config/update-tax', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
            }
        ]
    ],
]);
?>
<?php Pjax::end(); ?>