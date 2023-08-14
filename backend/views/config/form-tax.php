<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\TaxMaster;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord) ? 'Add new Tax' : 'Update Tax ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Tax', 'url' => ['tax']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'form-tax', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

        <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'name', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'name')->end() ?>

        <?= $form->field($model, 'code', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'code', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'code', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'code', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'code')->end() ?>

        <?= $form->field($model, 'value', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'value', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'value', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'value', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'value')->end() ?>

        <?= $form->field($model, 'type', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'type', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'type', common\ebl\Constants::$LABEL_TAX_TYPE, ['class' => 'form-control']) ?>
            <?= Html::error($model, 'type', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'type')->end() ?>

        <?= $form->field($model, 'applicable_on', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'applicable_on', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'applicable_on', common\ebl\Constants::LABEL_TAX_APPLICABLE_ON, ['class' => 'form-control chosen-select', 'multiple' => 'multiple']) ?>
            <?= Html::error($model, 'applicable_on', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'applicable_on')->end() ?>

        <?= $form->field($model, 'status', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'status', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'status', common\ebl\Constants::LABEL_STATUS, ['class' => 'form-control']) ?>
            <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'status')->end() ?>

        <div class="card-footer mg-t-auto">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
