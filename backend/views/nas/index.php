<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants;
use common\component\Utils;
use common\models\Nas;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Nas';
$this->params['links'] = [
    ['title' => 'Add New NAS', 'url' => \Yii::$app->urlManager->createUrl('nas/add-nas'), 'class' => 'fa fa-plus'],
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
                'ip_address',
                'secret',
                'description',
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
                        $items = [];
                        $items[] = Html::a('Edit NAS', Yii::$app->urlManager->createUrl(['nas/update-nas', 'id' => $data['id']]), ["class" => "nav-link"]);
                        $text = ($data['status']) ? 'Inactive NAS' : 'Active NAS';
                        $items[] = Html::a($text, 'javascript:void(0)', ['rec' => $data['id'], 'status' => ($data['status'] + 0), 'type' => 'statuschange', 'class' => 'ressus nav-link', 'data-placement' => 'left', 'data-toggle' => 'confirmation']);
                        $items[] = Html::a('Setting', Yii::$app->urlManager->createUrl(['nas/manage-nas', 'id' => $data['id']]), ["class" => "nav-link"]);
                        $items[] = Html::a("Restart", 'javascript:void(0)', ['rec' => $data['id'], 'type' => 'restart', 'class' => 'ressus nav-link', 'data-placement' => 'left', 'data-toggle' => 'confirmation']);
                        $items[] = Html::a("Flush All User", 'javascript:void(0)', ['rec' => $data['id'], 'type' => 'flush', 'class' => 'ressus nav-link', 'data-placement' => 'left', 'data-toggle' => 'confirmation']);

                        $head = Html::a(Html::tag("div", Html::tag("span", '', ["class" => "mg-r-5 tx-13 tx-medium fa fa-gear"]) .
                                                Html::tag("i", '', ["class" => "fa fa-angle-down mg-l-5"])
                                                , ["class" => "ht-45 pd-x-20 bd d-flex align-items-center justify-content-center"])
                                        , '', ["class" => "tx-gray-800 d-inline-block", "data-toggle" => "dropdown"]);

                        $navlist = Html::tag('div', Html::tag('nav', implode(" ", $items)
                                                , ['class' => 'nav nav-style-2 flex-column'])
                                        , ['class' => 'dropdown-menu pd-10 wd-200']
                        );

                        return Html::tag('div', $head . $navlist, ['class' => 'dropdown']);
                    }
                        ]
                    ],
                ]);
?>
                <?php Pjax::end(); ?>