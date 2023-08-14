<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\PlanPolicy;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($isNewRecord) ? 'Add new Policy Rules' : 'Update Policy Rule ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Policy Rules', 'url' => ['policy-rules']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['id' => 'form-policy-rules', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row">
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'name', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'name')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'days', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'days', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'days', \common\ebl\Constants::LABEL_DAYS_TYPES, ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'days', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'days')->end() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'start_time', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'start_time', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'start_time', \common\component\Utils::timeList(), ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'start_time', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'start_time')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'end_time', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'end_time', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'end_time', \common\component\Utils::timeList(), ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'end_time', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'end_time')->end() ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-xs-6">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'status', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'status', common\ebl\Constants::LABEL_STATUS, ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'status')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'limit_type', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'limit_type', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'limit_type', \common\ebl\Constants::LIMIT_TYPE, ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'limit_type', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'limit_type')->end() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'limit_value', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'limit_value', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'limit_value', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'limit_value', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'limit_value')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'limit_unit', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'limit_unit', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'limit_unit', \common\ebl\Constants::LIMIT_UNIT, ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'limit_unit', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'limit_unit')->end() ?>
                </div>
            </div>
        </div>

    </div>
    <div class="card-body row">
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <h6 class="br-section-label">Pre Speed Setting</h6>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'pre_upload', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'pre_upload', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'pre_upload', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'pre_upload', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'pre_upload')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'pre_download', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'pre_download', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'pre_download', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'pre_download', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'pre_download')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'pre_burst_threshhold', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'pre_burst_threshhold', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'pre_burst_threshhold', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'pre_burst_threshhold', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'pre_burst_threshhold')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'pre_burst_time', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'pre_burst_time', ['class' => 'ontrol-label']); ?>
                    <?= Html::activeTextInput($model, 'pre_burst_time', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'pre_burst_time', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'pre_burst_time')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'pre_burst_limit', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'pre_burst_limit', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'pre_burst_limit', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'pre_burst_limit', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'pre_burst_limit')->end() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <h6 class="br-section-label">Post Speed Setting</h6>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'post_upload', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'post_upload', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'post_upload', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'post_upload', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'post_upload')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'post_download', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'post_download', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'post_download', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'post_download', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'post_download')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'post_burst_threshhold', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'post_burst_threshhold', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'post_burst_threshhold', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'post_burst_threshhold', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'post_burst_threshhold')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'post_burst_time', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'post_burst_time', ['class' => 'ontrol-label']); ?>
                    <?= Html::activeTextInput($model, 'post_burst_time', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'post_burst_time', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'post_burst_time')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'post_burst_limit', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'post_burst_limit', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'post_burst_limit', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'post_burst_limit', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'post_burst_limit')->end() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer mg-t-auto">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::submitButton($isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>