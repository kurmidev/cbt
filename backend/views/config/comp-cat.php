<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use common\ebl\Constants;
use common\component\Utils;
use common\models\CompCat;
use common\component\ImsGridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Complaint Category';
$this->params['links'] = [
    ['title' => 'Add New Complaint Category', 'url' => \Yii::$app->urlManager->createUrl('config/add-comp-cat'), 'class' => 'fa fa-plus'],
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
                ['attribute' => 'parent_id', 'label' => 'Parent Category',
                    'content' => function($model) {
                        return !empty($model->parent) ? $model->parent->name : 'N/A';
                    },
                    'filter' => ArrayHelper::map(CompCat::find()->where(['>', 'parent_id', 0])->asArray()->all(), 'id', function($e) {
                        return $e["name"] . "(" . $e['code'] . ")";
                    }),
                ],
                ['attribute' => 'status', 'label' => 'Status',
                    'content' => function($model) {
                        return Utils::getLabels(Constants::LABEL_STATUS, $model->status);
                    },
                    'filter' => Constants::LABEL_STATUS,
                ],
                'description',
                'actionOn',
                'actionBy',
                ['label' => 'Action',
                    'content' => function ($data) {
                        return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['config/update-bank', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
                    }
                        ]
                    ],
                ]);
?>
                <?php Pjax::end(); ?>