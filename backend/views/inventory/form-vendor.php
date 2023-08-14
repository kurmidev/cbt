<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\VendorMaster;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord) ? 'Add new Vendor' : 'Update Vendor ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Vendor', 'url' => ['vendor']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'form-vendor', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

        <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'name', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'name')->end() ?>

        <?= $form->field($model, 'point_of_contact', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'point_of_contact', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'point_of_contact', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'point_of_contact', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'point_of_contact')->end() ?>

        <?= $form->field($model, 'mobile_no', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'mobile_no', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'mobile_no', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'mobile_no', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'name')->end() ?>

        <?= $form->field($model, 'email', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'email', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'email', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'email', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'email')->end() ?>

        <?= $form->field($model, 'pan_no', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'pan_no', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'pan_no', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'pan_no', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'pan_no')->end() ?>

        <?= $form->field($model, 'gst_no', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'gst_no', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'gst_no', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'gst_no', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'gst_no')->end() ?>

        <?= $form->field($model, 'status', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'status', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'status', common\ebl\Constants::LABEL_STATUS, ['class' => 'form-control', "option" => "Select Option"]) ?>
            <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'status')->end() ?>

        <?= $form->field($model, 'address', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'address', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextarea($model, 'address', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'address', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'address')->end() ?>


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
