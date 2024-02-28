<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;


/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord) ? 'Add new Broadcaster' : 'Update Broadcaster ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Broadcaster', 'url' => ['broadcaster']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'form-Broadcaster', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

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

        <?= $form->field($model, 'contact_no', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'contact_no', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'contact_no', ['class' => 'form-control','max'=>10]) ?>
            <?= Html::error($model, 'contact_no', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'contact_no')->end() ?>

        <?= $form->field($model, 'address', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'address', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'address', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'address', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'address')->end() ?>

        <?= $form->field($model, 'status', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'status', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?php
            $model->status = isset($model->status) ? $model->status + 0 : "";
            ?>
            <?= Html::activeDropDownList($model, 'status', C::LABEL_STATUS, ['class' => 'form-control', 'prompt' => "Select one"]) ?>
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