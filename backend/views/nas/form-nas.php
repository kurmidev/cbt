<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Nas;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id) ? 'Add new NAS' : 'Update NAS ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'NAS', 'url' => ['nas']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['id' => 'form-nas', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
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
                    <?= $form->field($model, 'ip_address', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'ip_address', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'ip_address', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'ip_address', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'ip_address')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'ports', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'ports', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'ports', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'ports', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'ports')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'type', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'type', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'type', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'type', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'type')->end() ?>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'secret', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'secret', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'secret', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'secret', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'secret')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'status', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'status', C::LABEL_STATUS, ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'status')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'username', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'username', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'username', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'username', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'username')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'password', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'password', ['class' => 'control-label']); ?>
                    <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'password', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'password')->end() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body row">
        <div class="col-lg-12 col-sm-12 col-xs-12 mb-5">
            <h6 class="br-section-label p-4">Pool Details</h6>
            <?= $this->render('_pool_list', ['model' => $model, 'form' => $form]) ?>
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
