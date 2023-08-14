<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Add new Migration Job';
$this->params['breadcrumbs'][] = ['label' => 'Migration', 'url' => ['job']];
$this->params['breadcrumbs'][] = $this->title;
$list = ArrayHelper::map(\common\models\DeviceMaster::find()->active()->all(), "id", "name");
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'migration-form', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'purchase_number', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'purchase_number', ['class' => 'control-label']); ?>
                <?= Html::activeTextInput($model, 'purchase_number', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'purchase_number', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'purchase_number')->end() ?>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'purchase_date', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'purchase_date', ['class' => 'control-label']); ?>
                <?= Html::activeTextInput($model, 'purchase_date', ['class' => 'form-control cal', 'readonly' => true]) ?>
                <?= Html::error($model, 'purchase_date', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'purchase_date')->end() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'invoice_number', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'invoice_number', ['class' => 'control-label']); ?>
                <?= Html::activeTextInput($model, 'invoice_number', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'invoice_number', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'invoice_number')->end() ?>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'invoice_date', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'invoice_date', ['class' => 'control-label']); ?>
                <?= Html::activeTextInput($model, 'invoice_date', ['class' => 'form-control cal', 'readonly' => true]) ?>
                <?= Html::error($model, 'invoice_date', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'invoice_date')->end() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'device_id', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'device_id', ['class' => 'control-label']); ?>
                <?= Html::activeDropDownList($model, 'device_id', $list, ['class' => 'form-control', 'prompt' => "Select options", "id" => "model"]) ?>
                <?= Html::error($model, 'device_id', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'device_id')->end() ?>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'file', ['options' => ['class' => "form-group"]])->begin(); ?>
                <?= Html::activeLabel($model, 'file', ['class' => 'control-label']) ?>
                <?= Html::activeFileInput($model, 'file', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'file', ['class' => 'error help-block']) ?>
                <?= $form->field($model, 'file')->end() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-sm-8 col-xs-8">
                <?php foreach ($model->dwnFields as $id => $field) { ?> 
                    <div class="pd-10 bd rounded disableall invisible"  id="<?= str_replace("\\", "_", $id) ?>">
                        <ul class="nav nav-gray-600 flex-column flex-sm-row" role="tablist">
                            <li class="nav-item">
                                <?= implode(", ", $field['cols']) ?>
                                <a class="pull-right" href="<?= Yii::$app->urlManager->createUrl(["/mig/download-sample", 'rel' => implode(", ", $field['cols']), 'filename' => $field['file']]) ?>"><span class="icon ion-arrow-down-a"></span></a>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="card-footer mt-2">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                    <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
