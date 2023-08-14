<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = empty($model->id) ? 'Add new Payment Gateway' : 'Update Payment Gateway ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Payment Gateway', 'url' => ['sms']];
$this->params['breadcrumbs'][] = $this->title;

$cnt = !empty($model->meta_data) ? array_keys($model->meta_data) : [0];
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'form-sms', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'name', ['class' => 'control-label']); ?>
                <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'name')->end() ?>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'pg_type', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'pg_type', ['class' => 'control-label']); ?>
                <?= Html::activeDropDownList($model, 'pg_type', C::LABEL_PG, ['class' => 'form-control', 'prompt' => "Select options"]) ?>
                <?= Html::error($model, 'pg_type', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'pg_type')->end() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'plugin_url', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'plugin_url', ['class' => 'control-label']); ?>
                <?= Html::activeTextInput($model, 'plugin_url', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'plugin_url', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'plugin_url')->end() ?>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'track_url', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'track_url', ['class' => 'control-label']); ?>
                <?= Html::activeTextInput($model, 'track_url', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'track_url', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'plugin_url')->end() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'status', ['options' => ['class' => "form-group"]])->begin(); ?>
                <?= Html::activeLabel($model, 'status', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
                <?= Html::activeDropDownList($model, 'status', C::LABEL_STATUS, ['class' => 'form-control']) ?>
                <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'status')->end() ?>
            </div>

            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'description', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'description', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
                <?= Html::activeTextarea($model, 'description', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'description', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'description')->end() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-4 col-xs-4">
                <?= $form->field($model, 'merchant_id', ['options' => ['class' => "form-group"]])->begin(); ?>
                <?= Html::activeLabel($model, 'merchant_id', ['class' => 'control-label']) ?>
                <?= Html::activeTextInput($model, 'merchant_id', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'merchant_id', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'merchant_id')->end() ?>
            </div>
            <div class="col-lg-4 col-sm-4 col-xs-4">
                <?= $form->field($model, 'merchant_salt', ['options' => ['class' => "form-group"]])->begin(); ?>
                <?= Html::activeLabel($model, 'merchant_salt', ['class' => 'control-label']) ?>
                <?= Html::activeTextInput($model, 'merchant_salt', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'merchant_salt', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'merchant_salt')->end() ?>
            </div>
            <div class="col-lg-4 col-sm-4 col-xs-4">
                <?= $form->field($model, 'merchant_key', ['options' => ['class' => "form-group"]])->begin(); ?>
                <?= Html::activeLabel($model, 'merchant_key', ['class' => 'control-label']) ?>
                <?= Html::activeTextInput($model, 'merchant_key', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'merchant_key', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'merchant_key')->end() ?>
            </div>
        </div>

        <div class="card-body row">
            <div class="col-lg-12 col-sm-12 col-xs-12 mb-5">
                <h6 class="br-section-label p-4">Other Attributes
                    <span class="pull-right"><?= Html::button('<span class="fa fa-plus btn btn-success btn-xs"></span>', ["class" => "btn btn-success", "onclick" => "addmoretablerow($('#rates'))"]) ?></span>
                </h6>
                <table class="table table-striped table-bordered"  id="clonetable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Value</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($cnt as $i) {
                            ?>
                            <tr>
                                <td>
                                    <?= $form->field($model, 'meta_data[' . $i . '][name]', ['options' => ['class' => 'form-group']])->begin() ?>
                                    <?= Html::activeTextInput($model, 'meta_data[' . $i . '][name]', ['class' => 'form-control  reset', "prompt" => "Select Option"]) ?>
                                    <?= Html::error($model, 'meta_data[' . $i . '][name]', ['class' => 'error help-block']) ?>
                                    <?= $form->field($model, 'meta_data[' . $i . '][name]')->end() ?>
                                </td>
                                <td>
                                    <?= $form->field($model, 'meta_data[' . $i . '][value]', ['options' => ['class' => 'form-group']])->begin() ?>
                                    <?= Html::activeTextInput($model, 'meta_data[' . $i . '][value]', ['class' => 'form-control  reset', "id" => "cost_price"]) ?>
                                    <?= Html::error($model, 'meta_data' . $i . '_value', ['class' => 'error help-block']) ?>
                                    <?= $form->field($model, 'meta_data[' . $i . '][value]')->end() ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" ><span class="fa fa-minus"></span></button> 
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer mg-t-auto">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                    <?= Html::submitButton($model->id ? 'Update' : 'Create', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
