<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants;
use common\component\Utils;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $title;
$url = $type == 2 ? \Yii::$app->urlManager->createUrl('opt-accounting/final-resoncile') : \Yii::$app->urlManager->createUrl('opt-accounting/deposit-resoncile');
$this->params['links'] = [
    ['title' => 'Reconsile Data', 'url' => $url, 'class' => 'fa fa-upload'],
    //['title' => 'Download', 'url' => \Yii::$app->urlManager->createUrl('downloads/index'), 'class' => 'fa fa-download'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_header') ?>
<?php Pjax::begin(); ?>
<?=

ImsGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $columns,
]);
?>
<?php Pjax::end(); ?>