<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Renew account {$model->username}.";
$this->params['breadcrumbs'][] = ['label' => 'Account', 'url' => ['account']];
$this->params['breadcrumbs'][] = $this->title;
$planList = common\models\PlanMaster::getAssignedPlan($model->operator_id, 1,C::PLAN_TYPE_BASE);
$disp = ArrayHelper::map($planList, 'id', 'name');
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'form-renew', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'plan_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'plan_id', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'plan_id', $disp, ['class' => 'form-control', 'prompt' => "select options", "id" => "plan_id"]) ?>
                    <?= Html::error($model, 'plan_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'plan_id')->end() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'start_date', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'start_date', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'start_date', ['class' => 'form-control reset', 'id' => 'start_date', 'readonly' => TRUE]) ?>
                    <?= Html::error($model, 'start_date', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'start_date')->end() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'end_date', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'end_date', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'end_date', ['class' => 'form-control reset', 'id' => 'end_date', 'readonly' => TRUE]) ?>
                    <?= Html::error($model, 'end_date', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'end_date')->end() ?>
                </div>
                <div class="col-sm-4">
                    <?= Html::label('Total Days', ['class' => 'control-label']); ?>
                    <?= Html::textInput('total_days', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'total_days']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    Franchise Pricing <hr>
                </div>
                <div class="col-sm-4">
                    <?= Html::label('Amount(A)', ['class' => 'control-label']); ?>
                    <?= Html::textInput('amount', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'amount']) ?>
                </div>
                <div class="col-sm-4">
                    <?= Html::label('Tax(B)', ['class' => 'control-label']); ?>
                    <?= Html::textInput('tax', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'tax']) ?>
                </div>
                <div class="col-sm-4">
                    <?= Html::label('Total(A+B)', ['class' => 'control-label']); ?>
                    <?= Html::textInput('total', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'total']) ?>
                </div>
            </div>
            <div class="row mg-t-20">
                <div class="col-sm-12">
                    Customer Pricing <hr>
                </div>
                <div class="col-sm-4">
                    <?= Html::label('Amount(A)', ['class' => 'control-label']); ?>
                    <?= Html::textInput('mrp', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'mrp']) ?>
                </div>
                <div class="col-sm-4">
                    <?= Html::label('Tax(B)', ['class' => 'control-label']); ?>
                    <?= Html::textInput('mrp_tax', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'mrp_tax']) ?>
                </div>
                <div class="col-sm-4">
                    <?= Html::label('Total(A+B)', ['class' => 'control-label']); ?>
                    <?= Html::textInput('mrp_total', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'mrp_total']) ?>
                </div>
            </div>

            <div class="row mg-t-20">
                <div class="col-sm-6">
                    <?= $form->field($model, 'operator_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::label('Franchise Wallet', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'operator_id', ['class' => 'form-control', "value" => $account->operator->balance, 'id' => 'end_date', 'readonly' => TRUE]) ?>
                    <?= Html::error($model, 'operator_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'operator_id')->end() ?>
                </div>
                <div class="col-sm-6">
                    <?= Html::label('Total Payable', ['class' => 'control-label']); ?>
                    <?= Html::textInput('total_amount', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'total_amounts']) ?>
                </div>
            </div>

        </div>

        <div class="card-footer mg-t-auto">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12 col-sm-offset-12 text-center">

                    <?php if ($account->operator->balance > 0 && count($account->activeAddons) <= 1) { ?>
                        <?= Html::submitButton('Activate Addons', ['class' => 'btn btn-primary center']) ?>
                    <?php } else if (count($account->activeBase) > 1) { ?>
                        <div class="alert alert-danger" role="alert">
                            Account already top-up with add-ons plan 
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-danger" role="alert">
                            Please recharge wallet to add add-ons on customer account!
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$url = Yii::$app->urlManager->createUrl(['ajax/plan-rates', 'id' => $account->id, 'type' => common\ebl\RateCalculation::ACTION_TYPE_ADDON]);
$js = '
        $(document).on("change","#plan_id",function(){    
                let plan_id = this.value;
                if(plan_id){
                    $.get("' . $url . '&plan_id="+plan_id, function( data ) {
                        if(data){
                            data = JSON.parse(data); 
                            const entries = Object.entries(data);
                            for (const [ids, values] of entries) {
                                $("#"+ids).val(values);
                              }
                            $("#total_amounts").val(data.total);
                        }
                    });
                 }else{
                   $(".reset").val("");
                 }


            });

        ';

$this->registerJs($js, $this::POS_READY);
?>