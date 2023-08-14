<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants as C;
use common\component\Utils;
use common\models\VendorMaster;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Vendor';
$this->params['links'] = [
    ['title' => 'Add New Vendor', 'url' => \Yii::$app->urlManager->createUrl('inventory/add-vendor'), 'class' => 'fa fa-plus'],
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
                return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['inventory/update-vendor', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
            }
        ],
        'name',
        'code',
        'point_of_contact:text:Contact Person',
        'mobile_no:text:Mobile No',
        "email:email:Email",
        "address:text:Address",
        "pan_no:text:Pan No",
        "gst_no:text:GST No.",
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