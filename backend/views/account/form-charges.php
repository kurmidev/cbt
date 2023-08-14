<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */


$this->title = "Terminate account {$model->username}.";
$this->params['breadcrumbs'][] = ['label' => 'Account', 'url' => ['account']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_mini_details', ['account' => $account]) ?>
<?php $form = ActiveForm::begin(['id' => 'form-payment', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p mg-t-10">
    <div class="card-header">Raise Charges/Bad Depths</div>
    <div class="card-body">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'amount', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'amount', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'amount', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'amount', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'amount')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'type', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'type', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'type', C::SUBSCRIBER_CHARGES, ['class' => 'form-control', 'prompt' => "Select options"]) ?>
                    <?= Html::error($model, 'type', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'type')->end() ?>
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
                <?= Html::submitButton("Raise Charges", ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
