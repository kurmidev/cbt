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
$this->title = 'Monthly Statement';
$this->params['links'] = [
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
        [
            "label" => "",
            "content" => function ($model) {
                return \yii\helpers\Html::a(\yii\helpers\Html::tag('span', '', ['class' => 'fa fa-print']), \Yii::$app->urlManager->createUrl(['cust-accounting/print-statement', 'id' => $model->account_id, 'month' => $model->stmonth]), ['title' => "Print Bill", 'class' => 'btn btn-primary-alt']);
            }
        ],
        'customer.name',
        'customer.cid',
        'account.username',
        "plans_amount",
        "debit_amount",
        "credit_amount",
        ['label' => 'Sub Amount (A+B+C)',
            'content' => function ($model) {
                return $model->plans_amount + $model->credit_amount + $model->debit_amount;
            },
        ],
        ['label' => 'Sub Tax',
            'content' => function ($model) {
                return $model->plans_tax + $model->credit_tax + $model->debit_tax;
            },
        ],
        "credit_nt_amount",
        "debit_nt_amount",
        "payment_amount",
        ['label' => 'Total',
            'content' => function ($model) {
                return $model->plans_amount + $model->credit_amount + $model->debit_amount + $model->plans_tax + $model->credit_tax + $model->debit_tax + $model->credit_nt_amount + $model->debit_nt_amount + $model->payment_amount;
            },
        ]
    ],
]);
?>
<?php Pjax::end(); ?>