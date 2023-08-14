<?php

use yii\helpers\Html;
use common\ebl\Constants as C;
?>
<div class="col-sm-6 mb-2">
    <div class="card">
        <div class="card-header">Account Details</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'username', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'username', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'username', ['class' => 'form-control', 'maxlength' => true]) ?>
                    <?= Html::error($model, 'username', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'username')->end() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'password', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'password', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'password', ['class' => 'form-control', 'maxlength' => true]) ?>
                    <?= Html::error($model, 'password', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'password')->end() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'is_auto_renew', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'is_auto_renew', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'is_auto_renew', C::LABEL_YESNO, ['class' => 'form-control', 'maxlength' => true, 'prompt' => "Select Options"]) ?>
                    <?= Html::error($model, 'is_auto_renew', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'is_auto_renew')->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>