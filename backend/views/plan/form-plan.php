<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = empty($model->id) ? 'Add new Plan' : 'Update Plan Rule ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Plan', 'url' => ['plan']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['id' => 'form-plan', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'name', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'name')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'display_name', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'display_name', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'display_name', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'display_name', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'display_name')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'plan_type', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'plan_type', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'plan_type', C::LABEL_PLAN_TYPE, ['class' => 'form-control', 'prompt' => 'select option']) ?>
                    <?= Html::error($model, 'plan_type', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'plan_type')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'status', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'status', C::LABEL_STATUS, ['class' => 'form-control', 'prompt' => 'select option']) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'status')->end() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'upload', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'upload', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'upload', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'upload', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'upload')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'download', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'download', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'download', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'download', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'download')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'upload_pearing', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'upload_pearing', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'upload_pearing', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'upload_pearing', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'upload_pearing')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'download_pearing', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'download_pearing', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'download_pearing', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'download_pearing', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'download_pearing')->end() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'limit_type', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'limit_type', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'limit_type', C::LIMIT_LABEL, ['class' => 'form-control','prompt'=>"select one"]) ?>
                    <?= Html::error($model, 'limit_type', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'limit_type')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'limit_value', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'limit_value', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'limit_value', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'limit_value', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'limit_value')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'reset_type', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'reset_type', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'reset_type', C::RESET_LABEL, ['class' => 'form-control','prompt'=>"select one"]) ?>
                    <?= Html::error($model, 'reset_type', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'reset_type')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'reset_value', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'reset_value', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'reset_value', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'reset_value', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'reset_value')->end() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'post_upload', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'post_upload', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'post_upload', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'post_upload', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'post_upload')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'post_download', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'post_download', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'post_download', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'post_download', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'post_download')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'post_upload_pearing', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'post_upload_pearing', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'post_upload_pearing', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'post_upload_pearing', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'post_upload_pearing')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'post_download_pearing', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'post_download_pearing', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'post_download_pearing', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'post_download_pearing', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'post_download_pearing')->end() ?>
                </div>
            </div>
        </div>
    </div>
   
    <div class="card-footer mg-t-auto">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::activeHiddenInput($model, 'id') ?>
                <?= Html::submitButton(empty($model->id) ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>