<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants;
use common\component\Utils;
use common\models\User;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Area';
$this->params['links'] = [
    ['title' => 'Add New Employee', 'url' => \Yii::$app->urlManager->createUrl('site/add-user'), 'class' => 'fa fa-plus'],
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
        'username',
        'mobile_no',
        'email',
        ['attribute' => 'user_type', 'label' => 'User Type',
            'content' => function ($model) {
                return !empty($model->user_type) ? C::LABEL_USERTYPE[$model->user_type] : null;
            },
        ],
        ['attribute' => 'designation_id', 'label' => 'Designation',
            'content' => function ($model) {
                return !empty($model->designation) ? $model->designation->name : "";
            },
            'filter' => \yii\helpers\ArrayHelper::map(\common\models\Designation::find()->where(['status' => C::STATUS_ACTIVE])->all(), 'id', 'name'),
        ],
        ['attribute' => 'status', 'label' => 'Status',
            'content' => function ($model) {
                return Utils::getLabels(Constants::LABEL_STATUS, $model->status);
            },
            'filter' => Constants::LABEL_STATUS,
        ],
        'actionOn',
        'actionBy',
        ['label' => 'Action',
            'content' => function ($data) {
                $ret = Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['site/update-user', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
                if (in_array($data['user_type'], [C::USERTYPE_STAFF])) {
                    $ret .= Html::a(Html::tag('span', '', ['class' => 'fa fa-gear']), \Yii::$app->urlManager->createUrl(['site/assign-operator', 'id' => $data['id']]), ['title' => 'Assign ' . C::OPERATOR_TYPE_LCO_NAME, 'class' => 'btn btn-primary-alt']);
                }
                return $ret;
            }
        ]
    ],
]);
?>
<?php Pjax::end(); ?>