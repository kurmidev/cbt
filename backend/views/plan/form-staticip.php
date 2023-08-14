<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id) ? 'Add new Static Ip Policy' : 'Update Static Ip Policy ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Static Ip Policy', 'url' => ['plan/staticip']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['id' => 'form-staticip', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row">
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'name', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'name')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'days', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'days', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'days', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'days', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'days')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'status', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'status', C::LABEL_STATUS, ['class' => 'form-control', 'prompt' => 'select option']) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'status')->end() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'description', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'description', ['class' => 'control-label']); ?>
                    <?= Html::activeTextarea($model, 'description', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'description', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'description')->end() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body row">
        <div class="col-lg-12 col-sm-12 col-xs-12 mb-5">
            <h6 class="br-section-label p-4">Price
                <span class="pull-right"><?= Html::button('<span class="fa fa-plus btn btn-success btn-xs"></span>', ["class" => "btn btn-success", "onclick" => "addmoretablerow($('#rates'))"]) ?></span>
            </h6>
            <?= $this->render('_rate_lists', ['model' => $model, 'form' => $form]) ?>
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
