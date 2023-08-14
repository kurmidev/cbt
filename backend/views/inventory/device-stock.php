<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants as C;
use common\component\Utils;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Inward Device';
$this->params['links'] = [
    ['title' => 'Inward Device', 'url' => \Yii::$app->urlManager->createUrl('inventory/inward-device'), 'class' => 'fa fa-plus'],
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
        'serial_no',
        "warranty_date",
        ['attribute' => 'vendor_id', 'label' => 'Vendor',
            'content' => function ($model) {
                return $model->vendor->name;
            },
            'filter' => yii\helpers\ArrayHelper::map(\common\models\VendorMaster::find()->active()->all(), "id", "name"),
        ],
        ['attribute' => 'device_id', 'label' => 'Device',
            'content' => function ($model) {
                return $model->device->name;
            },
            'filter' => yii\helpers\ArrayHelper::map(\common\models\DeviceMaster::find()->active()->all(), "id", "name"),
        ],
        "operator.name:text:Franchise",
        "operator.code:text:Franchise Code",
        "purchaseOrder.purchase_number:text:Purchase Order",
        ['attribute' => 'status', 'label' => 'Status',
            'content' => function ($model) {
                return Utils::getLabels(C::LABEL_DEVICE_STATUS, $model->status);
            },
            'filter' => C::LABEL_DEVICE_STATUS,
        ],
        'actionOn',
        'actionBy',
    ],
]);
?>
<?php Pjax::end(); ?>