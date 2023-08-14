<?php

use yii\helpers\Html;
use common\ebl\Constants as C;
?>
<div class="col-sm-6 mb-2">
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