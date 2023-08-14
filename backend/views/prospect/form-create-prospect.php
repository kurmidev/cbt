<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $planmodel common\models\Plans */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Add New Prospect';
$this->params['breadcrumbs'][] = ['label' => 'Prospect', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card  bd-0 shadow-base widget-14 ht-100p pd-10">
    <?php
    $form = ActiveForm::begin(['id' => 'prospect-add-form', 'options' => ['enctype' => 'multipart/form-data']]);
    ?>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">Contact Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeLabel($model, 'name', ['class' => 'control-label']); ?>
                                <?= Html::activeTextInput($model, 'name', ['class' => 'form-control', 'maxlength' => true]) ?>
                                <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'name')->end() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($model, 'gender', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeLabel($model, 'gender', ['class' => 'control-label']); ?>
                                <?= Html::activeDropDownList($model, 'gender', C::LABEL_GENDER, ['class' => 'form-control', 'prompt' => 'Select Gender']) ?>
                                <?= Html::error($model, 'gender', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'gender')->end() ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'dob', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeLabel($model, 'dob', ['class' => 'control-label']); ?>
                                <?= Html::activeTextInput($model, 'dob', ['class' => 'form-control dob', 'readonly' => TRUE]) ?>
                                <?= Html::error($model, 'dob', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'dob')->end() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($model, 'mobile_no', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeLabel($model, 'mobile_no', ['class' => 'control-label']); ?>
                                <?= Html::activeTextInput($model, 'mobile_no', ['class' => 'form-control', 'maxlength' => 10]) ?>
                                <?= Html::error($model, 'mobile_no', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'mobile_no')->end() ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'phone_no', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeLabel($model, 'phone_no', ['class' => 'control-label']); ?>
                                <?= Html::activeTextInput($model, 'phone_no', ['class' => 'form-control', 'maxlength' => 10]) ?>
                                <?= Html::error($model, 'phone_no', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'phone_no')->end() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($model, 'email', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeLabel($model, 'email', ['class' => ' control-label']); ?>
                                <?= Html::activeTextInput($model, 'email', ['class' => 'form-control']) ?>
                                <?= Html::error($model, 'email', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'email')->end() ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'connection_type', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeLabel($model, 'connection_type', ['class' => 'control-label']); ?>
                                <?= Html::activeDropDownList($model, 'connection_type', C::LABEL_CONNECTION_TYPE, ['class' => 'form-control', 'prompt' => 'Select Customer Type']) ?>
                                <?= Html::error($model, 'connection_type', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'connection_type')->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">Address Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'address', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeLabel($model, 'address', ['class' => ' control-label']); ?>
                                <?= Html::activeTextarea($model, 'address', ['class' => 'form-control', 'cols' => 8, 'rows' => 8]) ?>
                                <?= Html::error($model, 'address', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'address')->end() ?>
                            </div>
                            <div class="col-sm-12">
                                <?= $form->field($model, 'area_name', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeLabel($model, 'area_name', ['class' => ' control-label']); ?>
                                <?= Html::activeTextInput($model, 'area_name', ['class' => 'form-control']) ?>
                                <?= Html::error($model, 'area_name', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'area_name')->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <div class="card">
                    <div class="card-header">Prospect Info</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'description', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeLabel($model, 'description', ['class' => ' control-label']); ?>
                                <?= Html::activeTextarea($model, 'description', ['class' => 'form-control', 'cols' => 4, 'rows' => 4]) ?>
                                <?= Html::error($model, 'description', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'description')->end() ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'next_follow', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeLabel($model, 'next_follow', ['class' => ' control-label']); ?>
                                <?= Html::activeTextInput($model, 'next_follow', ['class' => 'form-control datepicker', 'readonly' => TRUE]) ?>
                                <?= Html::error($model, 'next_follow', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'next_follow')->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>