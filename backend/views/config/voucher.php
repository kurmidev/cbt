<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants as C;
use common\component\Utils;
use common\models\VoucherMaster;
use common\models\Operator;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Voucher/Coupons';
$this->params['links'] = [
    ['title' => 'Generate Voucher/Coupons', 'url' => \Yii::$app->urlManager->createUrl('config/gen-voucher'), 'class' => 'fa fa-plus'],
    ['title' => 'Assign Voucher/Coupons', 'url' => \Yii::$app->urlManager->createUrl('config/assign-voucher'), 'class' => 'fa fa-cog'],
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
        if ($model->status == C::VOUCHER_EXPIRED) {
            return ['style' => 'color:#dc3545; background-border:#dc3545;'];
        } else if ($model->status == C::VOUCHER_ASSGNED) {
            return ['style' => 'color:#28a745; background-border:#28a745;'];
        }
    },
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'coupon',
        ['attribute' => 'operator_id', 'label' => 'Franchise',
            'content' => function ($model) {
                return !empty($model->operator) ? $model->operator->name : "";
            },
            'filter' => ArrayHelper::map(Operator::find()->where(['type' => C::OPERATOR_TYPE_LCO])->asArray()->all(), 'id', function ($e) {
                return $e["name"] . "(" . $e['code'] . ")";
            }),
        ],
        ['attribute' => 'plan_id',
            'content' => function ($model) {
                return !empty($model->plan) ? $model->plan->name : "";
            },
            'filter' => ArrayHelper::map(common\models\PlanMaster::find()->asArray()->all(), 'id', function ($e) {
                return $e["name"] . "(" . $e['code'] . ")";
            }),
        ],
        ['attribute' => 'status', 'label' => 'Status',
            'content' => function ($model) {
                return Utils::getLabels(C::LABEL_VOUCHER, $model->status);
            },
            'filter' => C::LABEL_VOUCHER,
        ],
        'username:text:Username',
        'opt_amount:decimal:Franchise Discount',
        'cust_amount:decimal:Customer Discount',
        'actionOn',
        'actionBy',
    ],
]);
?>
<?php Pjax::end(); ?>