<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Change Password ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Change Password', 'url' => ['site']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'change-password-area', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

        <?= $form->field($model, 'password', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'password', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'password', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'password')->end() ?>

        <?= $form->field($model, 'confirmpassword', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'confirmpassword', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activePasswordInput($model, 'confirmpassword', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'confirmpassword', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'confirmpassword')->end() ?>

        <div class="card-footer mg-t-auto">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                    <?= Html::submitButton( 'Change Password', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
