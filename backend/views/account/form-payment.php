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
    <div class="card-header">Make Payment</div>
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
                    <?= $form->field($model, 'instrument_mode', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'instrument_mode', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'instrument_mode', C::LABEL_PAY_MODE, ['class' => 'form-control', 'prompt' => "Select options", 'id' => "instru_mode"]) ?>
                    <?= Html::error($model, 'instrument_mode', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'instrument_mode')->end() ?>
                </div>
            </div>
            <div class="row" id="disp_instr">
                <div class="col-lg-4 col-sm-4 col-xs-12">
                    <?= $form->field($model, 'instrument_nos', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'instrument_nos', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'instrument_nos', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'instrument_nos', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'instrument_nos')->end() ?>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-12">
                    <?= $form->field($model, 'instrument_bank', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'instrument_bank', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'instrument_bank', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'instrument_bank', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'instrument_bank')->end() ?>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-12">
                    <?= $form->field($model, 'instrument_date', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'instrument_date', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'instrument_date', ['class' => 'form-control cal']) ?>
                    <?= Html::error($model, 'instrument_date', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'instrument_date')->end() ?>
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
                <?= Html::submitButton("Make Payment", ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$js = '    
                    $("#disp_instr").hide();
            $(document).on("change","#instru_mode",function(){    
                let var_id = this.value;
                if(var_id!=="' . C::PAY_MODE_CASH . '"){
                    $("#disp_instr").show();
                }else{
                    $("#disp_instr").hide();
                }
            });

        ';

$this->registerJs($js, $this::POS_READY);
?>