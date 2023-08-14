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
$this->title = $type == Constants::OPERATOR_TYPE_DISTRIBUTOR ? Constants::OPERATOR_TYPE_DISTRIBUTOR_NAME :
        ($type == Constants::OPERATOR_TYPE_RO ? Constants::OPERATOR_TYPE_RO_NAME : Constants::OPERATOR_TYPE_LCO_NAME);
$this->params['links'] = [
    ['title' => 'Add New ' . $this->title, 'url' => \Yii::$app->urlManager->createUrl('operator/add-' . strtolower($this->title)), 'class' => 'fa fa-plus'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
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
    'columns' => $searchModel->displayColumn($type)
]);
?>
<?php Pjax::end(); ?>