<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants;
use common\component\Utils;
use common\models\Broadcaster;
use common\models\Genre;
use common\models\Language;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Services';
$this->params['links'] = [
    ['title' => 'Add New Services', 'url' => \Yii::$app->urlManager->createUrl('services/add-services'), 'class' => 'fa fa-plus'],
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
        [
            'attribute' => 'service_type', 'label' => 'Service Type',
            'content' => function ($model) {
                return Utils::getLabels(Constants::SERVICE_TYPE, $model->service_type);
            },
            'filter' => Constants::SERVICE_TYPE,
        ],
        [
            'attribute' => 'type', 'label' => 'Type',
            'content' => function ($model) {
                return Utils::getLabels(Constants::LABEL_HDSD, $model->type);
            },
            'filter' => Constants::LABEL_HDSD,
        ],
        [
            'attribute' => 'broadcaster_id', 'label' => 'Broadcaster',
            'content' => function ($model) {
                return !empty($model->broadcaster) ? $model->broadcaster->name : "N/A";
            },
            'filter' => ArrayHelper::map(Broadcaster::find()->active()->all(), 'id', 'name'),
        ],
        [
            'attribute' => 'language_id', 'label' => 'Language',
            'content' => function ($model) {
                return !empty($model->language) ? $model->language->name : "N/A";
            },
            'filter' => ArrayHelper::map(Language::find()->active()->all(), 'id', 'name'),
        ],
        [
            'attribute' => 'genre_id', 'label' => 'Genre',
            'content' => function ($model) {
                return !empty($model->genre) ? $model->genre->name : "N/A";
            },
            'filter' => ArrayHelper::map(Genre::find()->active()->all(), 'id', 'name'),
        ],
        [
            'attribute' => 'is_alacarte', 'label' => 'Is Alacarte',
            'content' => function ($model) {
                return Utils::getLabels(Constants::LABEL_YESNO, $model->is_alacarte);
            },
            'filter' => Constants::LABEL_YESNO,
        ],
        [
            'attribute' => 'is_fta', 'label' => 'Is FTA',
            'content' => function ($model) {
                return Utils::getLabels(Constants::LABEL_YESNO, $model->is_fta);
            },
            'filter' => Constants::LABEL_YESNO,
        ],
        'rate',
        [
            'attribute' => 'status', 'label' => 'Status',
            'content' => function ($model) {
                return Utils::getLabels(Constants::LABEL_STATUS, $model->status);
            },
            'filter' => Constants::LABEL_STATUS,
        ],
        'actionOn',
        'actionBy',
        [
            'label' => 'Action',
            'content' => function ($data) {
                return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['services/update-services', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
            }
        ]
    ],
]);
?>
<?php Pjax::end(); ?>