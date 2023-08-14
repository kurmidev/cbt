<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Renew account {$account->username}.";
$this->params['breadcrumbs'][] = ['label' => 'Account', 'url' => ['account']];
$this->params['breadcrumbs'][] = $this->title;
$planList = common\models\OperatorRates::find()->alias("a")->joinWith(['bouquet b'])
                ->andWhere(['a.operator_id' => $model->operator_id, 'b.status' => C::STATUS_ACTIVE, 'b.type' => C::PLAN_TYPE_BASE])->all();
$disp = ArrayHelper::map($planList, 'id', function ($d) {
            return $d->name;
        });
$planList = common\models\OperatorRates::find()->alias("a")->joinWith(['bouquet b'])
                ->andWhere(['a.operator_id' => $model->operator_id, 'b.status' => C::STATUS_ACTIVE, 'b.type' => C::PLAN_TYPE_ADDONS])->all();
$addondisp = ArrayHelper::map($planList, 'id', function ($d) {
            return $d->name;
        });
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'form-renew', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'bouquet_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'bouquet_id', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'bouquet_id', $disp, ['class' => 'form-control', 'prompt' => "select options", "id" => "plan_id", "onchange" => '$.get( "' . Yii::$app->urlManager->createUrl('ajax/data') . '&func=Voucher&operator_id=' . $model->operator_id . '&plan_id="+$("#plan_id").val(), function( data ) {
                                            $( "select#voucher_code" ).html( data );
				});']) ?>
                    <?= Html::error($model, 'bouquet_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'bouquet_id')->end() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'addon_ids', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'addon_ids', ['class' => 'control-label']); ?>
                    <?=
                    Html::activeDropDownList($model, 'addon_ids', $addondisp,
                            ['class' => 'form-control', 'prompt' => "select options", "id" => "addon_ids"])
                    ?>
                    <?= Html::error($model, 'addon_ids', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'addon_ids')->end() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'start_date', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'start_date', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'start_date', ['class' => 'form-control reset', 'id' => 'start_date', 'readonly' => TRUE]) ?>
                    <?= Html::error($model, 'start_date', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'start_date')->end() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'end_date', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'end_date', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'end_date', ['class' => 'form-control reset', 'id' => 'end_date', 'readonly' => TRUE]) ?>
                    <?= Html::error($model, 'end_date', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'end_date')->end() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="row mg-t-20">
                        <div class="col-sm-12">
                            Franchise Pricing <hr>
                        </div>
                        <div class="col-sm-4">
                            <?= Html::label('Amount(A)', ['class' => 'control-label']); ?>
                            <?= Html::textInput('total_amount', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'total_amount']) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= Html::label('Tax(B)', ['class' => 'control-label']); ?>
                            <?= Html::textInput('total_tax', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'total_tax']) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= Html::label('Total(A+B)', ['class' => 'control-label']); ?>
                            <?= Html::textInput('amount_total', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'amount_total']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">

                    <div class="row mg-t-20">
                        <div class="col-sm-12">
                            Customer Pricing <hr>
                        </div>
                        <div class="col-sm-4">
                            <?= Html::label('Amount(A)', ['class' => 'control-label']); ?>
                            <?= Html::textInput('total_mrp', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'total_mrp']) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= Html::label('Tax(B)', ['class' => 'control-label']); ?>
                            <?= Html::textInput('total_mrp_tax', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'total_mrp_tax']) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= Html::label('Total(A+B)', ['class' => 'control-label']); ?>
                            <?= Html::textInput('mrp_total', "", ['class' => 'form-control reset', 'readonly' => TRUE, 'id' => 'mrp_total']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mg-t-20">
                <div class="col-sm-12">
                    Payment <hr>
                </div>
                <div class="col-sm-12 col-xs-12 col-lg-12" id="inst_data">
                    <div class="row">
                        <div class="col-sm-3">
                            <?= $form->field($model, 'amount', ['options' => ['class' => 'form-group']])->begin() ?>
                            <?= Html::activeLabel($model, 'amount', ['class' => ' control-label']); ?>
                            <?= Html::activeTextInput($model, 'amount', ['class' => 'form-control']) ?>
                            <?= Html::error($model, 'amount', ['class' => 'error help-block']) ?>
                            <?= $form->field($model, 'amount')->end() ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'mode', ['options' => ['class' => 'form-group']])->begin() ?>
                            <?= Html::activeLabel($model, 'mode', ['class' => ' control-label']); ?>
                            <?= Html::activeDropDownList($model, 'mode', C::LABEL_PAY_MODE, ['class' => 'form-control']) ?>
                            <?= Html::error($model, 'mode', ['class' => 'error help-block']) ?>
                            <?= $form->field($model, 'mode')->end() ?>

                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'instrument_nos', ['options' => ['class' => 'form-group']])->begin() ?>
                            <?= Html::activeLabel($model, 'instrument_nos', ['class' => ' control-label']); ?>
                            <?= Html::activeTextInput($model, 'instrument_nos', ['class' => 'form-control']) ?>
                            <?= Html::error($model, 'instrument_nos', ['class' => 'error help-block']) ?>
                            <?= $form->field($model, 'instrument_nos')->end() ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'instrument_date', ['options' => ['class' => 'form-group']])->begin() ?>
                            <?= Html::activeLabel($model, 'instrument_date', ['class' => ' control-label']); ?>
                            <?= Html::activeTextInput($model, 'instrument_date', ['class' => 'form-control cal', 'readonly' => TRUE]) ?>
                            <?= Html::error($model, 'instrument_date', ['class' => 'error help-block']) ?>
                            <?= $form->field($model, 'instrument_date')->end() ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- <div class="row mg-t-20">
             <div class="col-sm-12">
                 Discount/Coupons <hr>
             </div>
             <div class="col-sm-12">
        <?= Html::activeDropDownList($model, 'voucher_code', [], ['class' => 'form-control reset', 'id' => 'voucher_code', 'prompt' => "Select Plan first"]) ?>
             </div>
         </div>-->

        <div class="card-footer mg-t-20">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12 col-sm-offset-12 text-center">

                    <?php if ($account->operator->balance > 0 && count($account->activeBase) <= 2) { ?>
                        <?= Html::submitButton('Renew Account', ['class' => 'btn btn-primary']) ?>
                    <?php } else if (count($account->activeBase) > 1) { ?>
                        <div class="alert alert-danger" role="alert">
                            Account already renewed in advance, can't renew further!
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-danger" role="alert">
                            Please recharge wallet to renew account!
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$url = Yii::$app->urlManager->createUrl(['ajax/data', 'func' => "PlanRates", 'id' => $account->id]);
$js = '
        $(document).on("change","#plan_id",function(){    
                let plan_id = this.value;
                if(plan_id){
                    $.get("' . $url . '&plan_id="+plan_id, function( data ) {
                        if(data){
                            data = JSON.parse(data);
                            delete data.b;
                            const entries = Object.entries(data);
                            console.log(entries);
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