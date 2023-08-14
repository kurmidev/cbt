<?php

use yii\bootstrap\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants;
use common\component\Utils as U;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Accounts';
$this->params['links'] = [
    ['title' => 'Add New Accounts', 'url' => \Yii::$app->urlManager->createUrl('account/add'), 'class' => 'fa fa-plus'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_header') ?>

<div class=" d-flex row-border br-section-wrapper">
    <div class="col-lg-12">
        <ul class="pagination pagination-circle pd-5 row">
            <?php
            foreach (range('a', 'z') as $char) {
                $class = ($searchModel->username == $char) ? 'active' : "";
                ?>
                <li class="page-item <?= $class ?> pd-1">
                    <?= Html::a(strtoupper($char), \Yii::$app->urlManager->createUrl(['account/index', 'CustomerAccountSearch[username_start]' => $char]), ["class" => 'page-link', 'style' => "width:33px"]) ?>                    
                </li>
            <?php }
            ?>
        </ul>
    </div>
</div>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/layouts/_advanceSearch', ['search' => $search, 'model' => $searchModel]) ?>

<?=
ImsGridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'rowOptions' => function ($model, $index, $widget, $grid) {
        if ($model->status == C::STATUS_TERMINATE) {
            return ['style' => 'color:#a94442;'];
        } else if ($model->status == C::STATUS_EXPIRED) {
            return ['style' => 'color:#dc3545;'];
        } else if (in_array($model->status, [C::STATUS_INACTIVATE_REFUND, C::STATUS_INACTIVE])) {
            return ['style' => 'color:#ffc607;'];
        }
    },
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['label' => 'Action',
            'content' => function ($data) {
                $link[] = Html::a('view', Yii::$app->urlManager->createUrl(['account/view', 'id' => $data['id']]), ["class" => "nav-link"]);
                if (in_array($data['status'], [C::STATUS_ACTIVE, C::STATUS_EXPIRED])) {
                    $link[] = Html::a('Renew', Yii::$app->urlManager->createUrl(['account/renewal', 'id' => $data['id']]), ["class" => "nav-link"]);
                    $link[] = Html::a('Addons', Yii::$app->urlManager->createUrl(['account/addons', 'id' => $data['id']]), ["class" => "nav-link"]);
                }
                if (!in_array($data['status'], [C::STATUS_TERMINATE])) {
                    $lbl = $data['status'] == C::STATUS_ACTIVE ? "Suspend" : "Resume";
                    $link[] = Html::a($lbl, Yii::$app->urlManager->createUrl(['account/susres', 'id' => $data['id']]), ["class" => "nav-link"]);
                    $link[] = Html::a('Setting', Yii::$app->urlManager->createUrl(['account/setting', 'id' => $data['id']]), ["class" => "nav-link"]);
                    $link[] = Html::a('Terminate', Yii::$app->urlManager->createUrl(['account/terminate', 'id' => $data['id']]), ["class" => "nav-link"]);
                }
                $link[] = Html::a('Payment', Yii::$app->urlManager->createUrl(['account/payment', 'id' => $data['id']]), ["class" => "nav-link"]);
                $link[] = Html::a('Charges', Yii::$app->urlManager->createUrl(['account/charges', 'id' => $data['id']]), ["class" => "nav-link"]);
                $link[] = Html::a('Complaint', Yii::$app->urlManager->createUrl(['account/complaint', 'id' => $data['id']]), ["class" => "nav-link"]);

                $head = Html::a(Html::tag("div", Html::tag("span", '', ["class" => "mg-r-5 tx-13 tx-medium fa fa-gear"]) .
                                        Html::tag("i", '', ["class" => "fa fa-angle-down mg-l-5"])
                                        , ["class" => "ht-45 pd-x-20 bd d-flex align-items-center justify-content-center"])
                                , '', ["class" => "tx-gray-800 d-inline-block", "data-toggle" => "dropdown"]);

                $navlist = Html::tag('div', Html::tag('nav', implode(" ", $link)
                                        , ['class' => 'nav nav-style-2 flex-column'])
                                , ['class' => 'dropdown-menu pd-10 wd-200']
                );

                return Html::tag('div', $head . $navlist, ['class' => 'dropdown']);
            }
        ],
        ['attribute' => 'cid', 'label' => 'Customer ID',
            'content' => function ($model) {
                return $model->cid;
            },
        ],
        'customer.name',
        'username',
        'customer.mobile_no',
        'customer.email',
        ['attribute' => 'customer.connection_type', 'label' => 'Conn Type',
            'content' => function ($model) {
                return U::getLabels(Constants::LABEL_CONNECTION_TYPE, $model->customer->connection_type);
            },
            'filter' => Constants::LABEL_CONNECTION_TYPE,
        ],
        [
            "attribute" => "operator_id",
            "label" => "Franchise",
            "content" => function ($model) {
                return !empty($model->operator) ? $model->operator->name : "";
            },
            'filter' => yii\helpers\ArrayHelper::map(common\models\Operator::find()->defaultCondition()->isFranchise()->active()->asArray()->all(), 'id', 'name')
        ],
        'start_date',
        'end_date',
        ['attribute' => 'status', 'label' => 'Status',
            'content' => function ($model) {
                return U::getStatusLabel($model->status);
            },
            'filter' => Constants::LABEL_STATUS,
        ],
        'actionOn',
        'actionBy',
    ],
]);
?>
<?php Pjax::end(); ?>