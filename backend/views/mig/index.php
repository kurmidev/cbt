<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\component\Utils;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Migration Jobs';
$url = $type == \common\models\ScheduleJobLogs::FILE_UPLOAD ? 'mig/migration-jobs' : 'mig/bulk-activity-job';
$this->params['links'] = [
    ['title' => 'Add New Job', 'url' => \Yii::$app->urlManager->createUrl($url), 'class' => 'fa fa-plus'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_header') ?>
<?php Pjax::begin(); ?>
<?=

ImsGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => '_id', 'label' => 'Job Id',
            'content' => function ($model) {
                return $model->_id;
            },
        ],
        ['attribute' => 'model', 'label' => 'Migration Type',
            'content' => function ($model) {
                return !empty(common\ebl\Constants::LABEL_JOB_MODELS[$model->model]) ? common\ebl\Constants::LABEL_JOB_MODELS[$model->model] : $model->model;
            },
        ],
        ['attribute' => 'success_record', 'label' => 'Success',
            "content" => function ($model) {
                return Html::tag("span", $model->success_record, ['class' => "tx-success"]);
            }
        ],
        ['attribute' => 'error_record', 'label' => 'Error',
            "content" => function ($model) {
                return Html::tag("span", $model->error_record, ['class' => "tx-danger"]);
            }
        ],
        ['attribute' => 'total_record', 'label' => 'Total',
            "content" => function ($model) {
                $url = $model->total_record;
                if (!empty($model->response)) {
                    $link = Yii::$app->urlManager->createUrl(['mig/download', 'id' => $model->_id]);
                    $url = Html::a($model->total_record, $link, ['target' => "_blank", 'data-pjax' => "0"]);
                }
                return Html::tag("span", $url, ['class' => "tx-inverse"]);
            }
        ],
        ['attribute' => 'status', 'label' => 'Status',
            'content' => function ($model) {
                return $model->statusLabel;
            },
            'filter' => common\ebl\Constants::LABEL_JOB_STATUS,
        ],
        'message',
        'actionOn',
        'actionBy',
    ],
]);
?>
<?php Pjax::end(); ?>