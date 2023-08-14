<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */
$this->title = "Recharge wallet $model->name";
$this->params['breadcrumbs'][] = ['label' => 'Recharge Wallet', 'url' => ['operator']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="row">
        <div class="col-lg-8 col-sm-8 col-xs-8">
            <div class="card-body">
                <?php $form = ActiveForm::begin(['id' => 'form-recharge', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered'], 'enableClientValidation' => false]); ?>

                <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'name', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
                <div class="col-lg-8 col-sm-8 col-xs-8">
                    <?= Html::activeTextInput($model, 'name', ['class' => 'form-control', 'readonly' => TRUE]) ?>
                    <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'name')->end() ?>

                <?= $form->field($model, 'balance', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'balance', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
                <div class="col-lg-8 col-sm-8 col-xs-8">
                    <?= Html::activeTextInput($model, 'balance', ['class' => 'form-control', 'readonly' => TRUE]) ?>
                    <?= Html::error($model, 'balance', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'balance')->end() ?>

                <?= $form->field($model, 'amount', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'amount', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
                <div class="col-lg-8 col-sm-8 col-xs-8">
                    <?= Html::activeTextInput($model, 'amount', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'amount', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'balance')->end() ?>


                <?= $form->field($model, 'mode', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'mode', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
                <div class="col-lg-8 col-sm-8 col-xs-8">
                    <?= Html::activeDropDownList($model, 'mode', Constants::LABEL_PAY_MODE, ['class' => 'form-control', 'id' => 'mode']) ?>
                    <?= Html::error($model, 'mode', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'mode')->end() ?>


                <div class="col-sm-10 col-xs-10 col-lg-10" id="inst_data"  style="display: none">
                    <div class="row">
                        <?= $form->field($model, 'instrument_name', ['options' => ['class' => 'form-group']])->begin() ?>
                        <?= Html::activeLabel($model, 'instrument_name', ['class' => 'col-lg-12 col-sm-12 col-xs-12 control-label']); ?>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <?= Html::activeTextInput($model, 'instrument_name', ['class' => 'form-control']) ?>
                            <?= Html::error($model, 'instrument_name', ['class' => 'error help-block']) ?>
                        </div>
                        <?= $form->field($model, 'instrument_name')->end() ?>

                        <?= $form->field($model, 'instrument_nos', ['options' => ['class' => 'form-group']])->begin() ?>
                        <?= Html::activeLabel($model, 'instrument_nos', ['class' => 'col-lg-12 col-sm-12 col-xs-12 control-label']); ?>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <?= Html::activeTextInput($model, 'instrument_nos', ['class' => 'form-control']) ?>
                            <?= Html::error($model, 'instrument_nos', ['class' => 'error help-block']) ?>
                        </div>
                        <?= $form->field($model, 'instrument_nos')->end() ?>

                        <?= $form->field($model, 'instrument_date', ['options' => ['class' => 'form-group']])->begin() ?>
                        <?= Html::activeLabel($model, 'instrument_date', ['class' => 'col-lg-12 col-sm-12 col-xs-12 control-label']); ?>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <?= Html::activeTextInput($model, 'instrument_date', ['class' => 'form-control cal', 'readonly' => TRUE]) ?>
                            <?= Html::error($model, 'instrument_date', ['class' => 'error help-block']) ?>
                        </div>
                        <?= $form->field($model, 'instrument_date')->end() ?>

                    </div>
                </div>

                <div class="col-sm-10 col-xs-10 col-lg-10" id="pg_show"  style="<?= !empty($model->mode) && $model->mode == Constants::PAY_MODE_ONLINE_TRANSFER ? "" : "display:none" ?>">
                    <?= $form->field($model, 'pg_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'pg_id', ['class' => 'col-lg-4 col-sm-4 col-xs-4 control-label']); ?>
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <?= Html::activeDropDownList($model, 'pg_id', $pglist, ['class' => 'form-control', 'id' => 'pg_id', 'option' => "select option"]) ?>
                        <?= Html::error($model, 'pg_id', ['class' => 'error help-block']) ?>
                    </div>
                    <?= $form->field($model, 'mode')->end() ?>
                </div>

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
                            <?= Html::submitButton('Recharge', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-4">
            <div class="card-body">

            </div>
        </div>
    </div>
</div>

<?php
$js = ' $("#mode").change(function(){
         $("#inst_data").hide();
         $("#pg_show").hide();
            if(this.value != "' . Constants::PAY_MODE_CASH . '" && this.value != "' . Constants::PAY_MODE_PAYMENT_GATEWAY . '"){
                $("#inst_data").show();
            }
            if(this.value=="' . Constants::PAY_MODE_PAYMENT_GATEWAY . '"){
                $("#pg_show").show();
            }
        });
 ';
$this->registerJs($js, $this::POS_READY);
?>