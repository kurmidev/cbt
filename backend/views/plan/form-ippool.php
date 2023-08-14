<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = empty($model->id) ? 'Add new IP Pool' : 'Update IP Pool ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'IP POOL', 'url' => ['ippool']];
$this->params['breadcrumbs'][] = $this->title;

$pluginList = ArrayHelper::map(\common\models\PluginMasterSearch::find()->active()->where(['plugin_type' => C::PLUGIN_TYPE_NAS])->asArray()->all(), 'id', 'name');
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'form-ippool', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

        <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'name', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'name')->end() ?>


        <?= $form->field($model, 'ip_address', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'ip_address', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'ip_address', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'ip_address', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'ip_address')->end() ?>


        <?= $form->field($model, 'type', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'type', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'type', common\ebl\Constants::POOL_TYPES, ['class' => 'form-control','prompt'=>"Select Options"]) ?>
            <?= Html::error($model, 'type', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'type')->end() ?>


        <?= $form->field($model, 'plugin_id', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'plugin_id', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label','label'=>"Plugin"]) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'plugin_id', $pluginList, ['class' => 'form-control','prompt'=>"Select Options"]) ?>
            <?= Html::error($model, 'plugin_id', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'plugin_id')->end() ?>

        <?= $form->field($model, 'status', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'status', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'status', common\ebl\Constants::LABEL_STATUS, ['class' => 'form-control', 'prompt' => "Select Option"]) ?>
            <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'status')->end() ?>


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
