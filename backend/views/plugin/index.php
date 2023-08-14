<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants as C;
use common\component\Utils;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Plugins';
$this->params['links'] = [
    ['title' => 'SMS', 'url' => \Yii::$app->urlManager->createUrl('plugin/add-sms'), 'class' => 'fa fa-comments'],
    ['title' => 'Payment Gateway', 'url' => \Yii::$app->urlManager->createUrl('plugin/add-pg'), 'class' => 'fa fa-money'],
    ['title' => 'NAS', 'url' => \Yii::$app->urlManager->createUrl('plugin/add-nas'), 'class' => 'fa fa-wifi'],
    ['title' => 'OTT', 'url' => \Yii::$app->urlManager->createUrl('plugin/add-ott'), 'class' => 'fa fa-film'],
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
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        "plugin_url",
        "description",
        ['attribute' => 'plugin_type', 'label' => 'Plugin Type',
            'content' => function ($model) {
                return Utils::getLabels(C::LABEL_PLUGIN_TYPE, $model->plugin_type);
            },
            'filter' => C::LABEL_PLUGIN_TYPE,
        ],
        ['attribute' => 'status', 'label' => 'Status',
            'content' => function ($model) {
                return Utils::getLabels(C::LABEL_STATUS, $model->status);
            },
            'filter' => C::LABEL_STATUS,
        ],
        'actionOn',
        'actionBy',
        ['label' => 'Action',
            'content' => function ($data) {
                $lbl = "Edit ";
                $func = "";
                switch ($data['plugin_type']) {
                    case C::PLUGIN_TYPE_MOBILE_SMS:
                        $lbl .= "SMS";
                        $func = "add-sms";
                        break;
                    case C::PLUGIN_TYPE_PAYMENT_GATEWAY:
                        $lbl .= "Payment Gateway ";
                        $func = "add-pg";
                        break;
                    case C::PLUGIN_TYPE_OTT:
                        $lbl .= "OTT";
                        $func = "add-ott";
                        break;
                    case C::PLUGIN_TYPE_NAS:
                        $lbl .= "NAS";
                        $func = "add-nas";
                        break;
                    default :
                        break;
                }
                return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(["plugin/{$func}", 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
            }
        ]
    ],
]);
?>
<?php Pjax::end(); ?>