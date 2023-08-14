<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */


$this->title = "Raise Coimplaint for user  <b>{$account->username}</b>.";
$this->params['breadcrumbs'][] = ['label' => 'Account', 'url' => ['account']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_mini_details', ['account' => $account]) ?>
<?php $form = ActiveForm::begin(['id' => 'form-complaint', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p mg-t-10">
    <div class="card-header">Raise Ticket</div>
    <div class="card-body">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'category_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'category_id', ['class' => 'control-label']); ?>
                    <?php $list = ArrayHelper::map(common\models\CompCat::find()->active()->asArray()->all(), 'id', 'name') ?>
                    <?= Html::activeDropDownList($model, 'category_id', $list, ['class' => 'form-control chosen-select', 'prompt' => "Select options"]) ?>
                    <?= Html::error($model, 'category_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'category_id')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'assigned_user', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'assigned_user', ['class' => 'control-label']); ?>
                    <?php $list = ArrayHelper::map(\common\models\User::find()->excludeHighGrnd()->defaultCondition()->andWhere(['OR', ['reference_id' => $account->operator_id], ['reference_id' => \common\models\User::getMso()]])->active()->asArray()->all(), 'id', 'name') ?>
                    <?= Html::activeDropDownList($model, 'assigned_user', $list, ['class' => 'form-control chosen-select', 'prompt' => "Select options"]) ?>
                    <?= Html::error($model, 'assigned_user', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'assigned_user')->end() ?>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'nextfollowup', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'nextfollowup', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'nextfollowup', ['class' => 'form-control cal', 'readonly' => true]) ?>
                    <?= Html::error($model, 'nextfollowup', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'nextfollowup')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'stages', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'stages', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'stages', C::COMPLAINT_SATGES, ['class' => 'form-control chosen-select', 'prompt' => "Select options"]) ?>
                    <?= Html::error($model, 'stages', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'stages')->end() ?>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'remark', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'remark', ['class' => 'control-label']); ?>
                    <?= Html::activeTextarea($model, 'remark', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'remark', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'remark')->end() ?>
                </div>
            </div>

        </div>

    </div>
    <div class="card-footer mg-t-auto">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12 col-sm-offset-12 text-center">
                <?= Html::submitButton("Raise Ticket", ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
