<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\VendorMaster;
use common\ebl\Constants as C;

$cnt = !empty($model->device_attributes) ? count($model->device_attributes) : count(C::DEVICE_ATTRIBUTE_LIST);

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord) ? 'Add new Vendor' : 'Update Vendor ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Vendor', 'url' => ['vendor']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'form-vendor', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

        <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'name', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'name')->end() ?>

        <?= $form->field($model, 'vendor_id', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'vendor_id', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?php $list = ArrayHelper::map(VendorMaster::find()->active()->asArray()->all(), 'id', 'name'); ?>
            <?= Html::activeDropDownList($model, 'vendor_id', $list, ['class' => 'form-control', "option" => "Select Option"]) ?>
            <?= Html::error($model, 'vendor_id', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'vendor_id')->end() ?>

        <?= $form->field($model, 'status', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'status', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'status', common\ebl\Constants::LABEL_STATUS, ['class' => 'form-control', "option" => "Select Option"]) ?>
            <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'status')->end() ?>

        <?= $form->field($model, 'amount', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'amount', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'amount', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'amount', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'amount')->end() ?>


        <?= $form->field($model, 'units', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'units', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'units', common\ebl\Constants::LABEL_MEASUREMENT, ['class' => 'form-control', "option" => "Select Option"]) ?>
            <?= Html::error($model, 'units', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'units')->end() ?>

        <?= $form->field($model, 'description', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'description', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextarea($model, 'description', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'description', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'description')->end() ?>

        <div class="card-body row">
            <div class="col-lg-12 col-sm-12 col-xs-12 mb-5">
                <h6 class="br-section-label p-4">Add/Update Attributes
                    <span class="pull-right"><?= Html::button('<span class="fa fa-plus btn btn-success btn-xs"></span>', ["class" => "btn btn-success", "onclick" => "addmoretablerow($('#rates'))"]) ?></span>
                </h6>

                <table class="table table-striped table-bordered" id="clonetable">
                    <thead>
                        <tr>
                            <th>Attributes</th>
                            <th>Validation Types</th>
                            <th>Length</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        for ($i = 1; $i <= $cnt; $i++) {
                            ?>
                            <tr>
                                <td>
                                    <?= $form->field($model, 'device_attributes[' . $i . '][name]', ['options' => ['class' => 'form-group']])->begin() ?>
                                    <?= Html::activeTextInput($model, 'device_attributes[' . $i . '][name]', ['class' => 'form-control  reset', "prompt" => "Select Option"]) ?>
                                    <?= Html::error($model, 'device_attributes[' . $i . '][name]', ['class' => 'error help-block']) ?>
                                    <?= $form->field($model, 'device_attributes[' . $i . '][name]')->end() ?>
                                </td>
                                <td>
                                    <?= $form->field($model, 'device_attributes[' . $i . '][type]', ['options' => ['class' => 'form-group']])->begin() ?>
                                    <?= Html::activeDropDownList($model, 'device_attributes[' . $i . '][type]', C::ATTRIBUTE_VALIDATION_TYPE, ['class' => 'form-control  reset', 'prompt' => "Select Options"]) ?>
                                    <?= Html::error($model, 'device_attributes' . $i . 'type', ['class' => 'error help-block']) ?>
                                    <?= $form->field($model, 'device_attributes[' . $i . '][type]')->end() ?>
                                </td>
                                <td>
                                    <?= $form->field($model, 'device_attributes[' . $i . '][length]', ['options' => ['class' => 'form-group']])->begin() ?>
                                    <?= Html::activeTextInput($model, 'device_attributes[' . $i . '][length]', ['class' => 'form-control  reset', 'prompt' => "Select Options"]) ?>
                                    <?= Html::error($model, 'device_attributes' . $i . 'length', ['class' => 'error help-block']) ?>
                                    <?= $form->field($model, 'device_attributes[' . $i . '][length]')->end() ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" ><span class="fa fa-minus"></span></button> 
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>
                                <?= $form->field($model, 'device_attributes[0][name]', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeTextInput($model, 'device_attributes[0][name]', ['class' => 'form-control  reset', "value" => "serial_no", "readonly" => true]) ?>
                                <?= Html::error($model, 'device_attributes[0][name]', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'device_attributes[0][name]')->end() ?>
                            </td>
                            <td>
                                <?= $form->field($model, 'device_attributes[0][type]', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeDropDownList($model, 'device_attributes[0][type]', C::ATTRIBUTE_VALIDATION_TYPE, ['class' => 'form-control  reset', 'prompt' => "Select Options"]) ?>
                                <?= Html::error($model, 'device_attributes[0][type]', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'device_attributes[0][type]')->end() ?>
                            </td>
                            <td>
                                <?= $form->field($model, 'device_attributes[0][length]', ['options' => ['class' => 'form-group']])->begin() ?>
                                <?= Html::activeTextInput($model, 'device_attributes[0][length]', ['class' => 'form-control  reset', 'prompt' => "Select Options"]) ?>
                                <?= Html::error($model, 'device_attributes[0][length]', ['class' => 'error help-block']) ?>
                                <?= $form->field($model, 'device_attributes[0][length]')->end() ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer mg-t-auto">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>