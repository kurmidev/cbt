<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Location;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord) ? 'Add new Area' : 'Update Area ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Area', 'url' => ['area']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'form-area', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

        <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'name', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'name')->end() ?>


        <?= $form->field($model, 'city_id', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'city_id', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?php
            $list = ArrayHelper::map(common\models\Location::find()->where(["status" => common\ebl\Constants::STATUS_ACTIVE, 'type' => common\ebl\Constants::LOCATION_CITY])
                                    ->all(), 'id', 'name');
            ?>
            <?= Html::activeDropDownList($model, 'city_id', $list, ['class' => 'form-control chosen-select']) ?>
            <?= Html::error($model, 'city_id', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'city_id')->end() ?>


        <?= $form->field($model, 'status', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'status', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?php
            $model->status = isset($model->status) ? $model->status + 0 : "";
            ?>
            <?= Html::activeDropDownList($model, 'status', common\ebl\Constants::LABEL_STATUS, ['class' => 'form-control']) ?>
            <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'status')->end() ?>


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
