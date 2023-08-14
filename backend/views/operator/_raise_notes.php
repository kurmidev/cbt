<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */
$this->title = "Raise Credit/Debit Note $opt->name";
$this->params['breadcrumbs'][] = ['label' => 'Raise Credit/Debit Note', 'url' => ['operator']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="row">
        <div class="col-lg-8 col-sm-8 col-xs-8">
            <div class="card-body">
                <?php $form = ActiveForm::begin(['id' => 'form-raise-note', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered'], 'enableClientValidation' => false]); ?>
                <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'name', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
                <div class="col-lg-8 col-sm-8 col-xs-8">
                    <?= Html::activeTextInput($model, 'name', ['class' => 'form-control', 'readonly' => TRUE]) ?>
                    <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'name')->end() ?>

                <?= $form->field($model, 'type', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'type', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
                <div class="col-lg-8 col-sm-8 col-xs-8">
                    <?= Html::activeDropDownList($model, 'type', Constants::PARTICULAR_LABEL, ['class' => 'form-control',"prompt"=>"Select Options", 'id' => 'type', 'onchange' => '$.get( "' . Yii::$app->urlManager->createUrl(['ajax/data', "func" => "particulars", "operator_id" => $model->operator_id]) . '&transtype="+$("#type").val()+"&notetype="+$("#type").val(), function( data ) {
                    $( "select#instrument_nos" ).html( data );
                    });']) ?>
                    <?= Html::error($model, 'type', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'type')->end() ?>

                <?= $form->field($model, 'instrument_nos', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'instrument_nos', ['class' => 'col-lg-12 col-sm-12 col-xs-12 control-label']); ?>
                <div class="col-lg-8 col-sm-8 col-xs-8">
                    <?= Html::activeDropDownList($model, 'instrument_nos', [], ['class' => 'form-control', 'id' => 'instrument_nos', 'prompt' => "Select Options"]) ?>
                </div>
                <?= $form->field($model, 'instrument_nos')->end() ?>


                <?= $form->field($model, 'amount', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'amount', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
                <div class="col-lg-8 col-sm-8 col-xs-8">
                    <?= Html::activeTextInput($model, 'amount', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'amount', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'amount')->end() ?>

                <?= $form->field($model, 'is_taxable', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'is_taxable', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
                <div class="col-lg-8 col-sm-8 col-xs-8">
                    <?= Html::activeDropDownList($model, 'is_taxable', Constants::CONFIRM_LABEL, ['class' => 'form-control', 'id' => 'type']) ?>
                    <?= Html::error($model, 'is_taxable', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'is_taxable')->end() ?>

                <?= $form->field($model, 'instrument_date', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'instrument_date', ['class' => 'col-lg-12 col-sm-12 col-xs-12 control-label']); ?>
                <div class="col-lg-8 col-sm-8 col-xs-8">
                    <?= Html::activeTextInput($model, 'instrument_date', ['class' => 'form-control cal', 'readonly' => TRUE]) ?>
                    <?= Html::error($model, 'instrument_date', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'instrument_date')->end() ?>

                <?= $form->field($model, 'remark', ['options' => ['class' => "form-group"]])->begin(); ?>
                <?= Html::activeLabel($model, 'remark', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
                <div class="col-lg-8 col-sm-8 col-xs-8">
                    <?= Html::activeTextarea($model, 'remark', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'remark', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'remark')->end() ?>

                <div class="card-footer mg-t-auto">
                    <div class="row">
                        <div class="col-lg-8 col-sm-8 col-xs-8 col-sm-offset-3">
                            <?= Html::submitButton('Raise Notes', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
