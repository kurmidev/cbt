<?php

use yii\bootstrap\Html;
use common\ebl\Constants as C;

$list = \yii\helpers\ArrayHelper::map(\common\models\User::find()->excludeHighGrnd()->asArray()->all(), 'id', 'name');
?>


<div class="card">
    <div class="card-header">KYC Process</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'verified_by', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'verified_by', ['class' => 'control-label']); ?>
                <?= Html::activeDropDownList($model, 'verified_by', $list, ['class' => 'form-control', 'prompt' => 'Select one']) ?>
                <?= Html::error($model, 'verified_by', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'verified_by')->end() ?>
            </div>

            <div class="col-sm-3">
                <?= $form->field($model, 'verified_on', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'verified_on', ['class' => 'control-label']); ?>
                <?= Html::activeTextInput($model, 'verified_on', ['class' => 'form-control cal', 'readonly' => TRUE]) ?>
                <?= Html::error($model, 'verified_on', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'verified_on')->end() ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'status', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'status', ['class' => 'control-label']); ?>
                <?= Html::activeDropDownList($model, 'status', [C::STATUS_PENDING => 'Pending', C::STATUS_CLOSED => "Closed"], ['class' => 'form-control', 'id' => 'status'])
                ?>
                <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'status')->end() ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'next_follow', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'next_follow', ['class' => 'control-label']); ?>
                <?= Html::activeTextInput($model, 'next_follow', ['class' => 'form-control calfwd', 'readonly' => TRUE]) ?>
                <?= Html::error($model, 'next_follow', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'next_follow')->end() ?>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-6" id="disp_<?= $model->stages ?>">
                <?= $form->field($model, 'assigned_engg', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'assigned_engg', ['class' => 'control-label']); ?>
                <?= Html::activeDropDownList($model, 'assigned_engg', $list, ['class' => 'form-control', 'prompt' => 'Select one']) ?>
                <?= Html::error($model, 'assigned_engg', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'assigned_engg')->end() ?>
            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'remark', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'remark', ['class' => 'control-label']); ?>
                <?= Html::activeTextarea($model, 'remark', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'remark', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'remark')->end() ?>
            </div>
        </div>
    </div>
</div>