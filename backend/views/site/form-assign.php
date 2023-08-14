<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;
use common\component\ImsGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Assign " . C::OPERATOR_TYPE_LCO_NAME;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['user']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'form-assign-operator', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
        <?=
        ImsGridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'checkboxOptions' => function ($model, $key, $index, $column) use ($user) {
                        return [
                    'value' => $model->id,
                    "checked" => (in_array($model->id, $user->assigedList)),
                        ];
                    },
                    "name" => 'AssignmentForm[assign_ids][]'
                ],
                'name',
                'code',
                [
                    'attribute' => 'distributor_id',
                    'label' => C::OPERATOR_TYPE_DISTRIBUTOR_NAME,
                    'content' => function ($model) {
                        return !empty($model->distributor) ? $model->distributor->name : null;
                    },
                    'filter' => \yii\helpers\ArrayHelper::map(common\models\Operator::find()
                                    ->where(['type' => C::OPERATOR_TYPE_DISTRIBUTOR])
                                    ->andFilterWhere(['or', ['id' => $user->reference_id], ['distributor_id' => $user->reference_id], ['mso_id' => $user->reference_id]])
                                    ->all(), 'id', 'name'),
                ],
                [
                    'attribute' => 'distributor_id',
                    'label' => C::OPERATOR_TYPE_DISTRIBUTOR_NAME . " Code",
                    'content' => function ($model) {
                        return !empty($model->distributor) ? $model->distributor->code : null;
                    },
                    'filter' => \yii\helpers\ArrayHelper::map(common\models\Operator::find()
                                    ->where(['type' => C::OPERATOR_TYPE_DISTRIBUTOR])
                                    ->andFilterWhere(['or', ['id' => $user->reference_id], ['distributor_id' => $user->reference_id], ['mso_id' => $user->reference_id]])
                                    ->all(), 'id', 'name'),
                ]
            ],
        ]);
        ?>
        

        <div class="card-footer mg-t-10">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12 ">
                    <?= Html::submitButton('Assign', ['class' => 'btn btn-primary text']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
