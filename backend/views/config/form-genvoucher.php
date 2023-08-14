<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Generate Voucher/Coupons";
$this->params['breadcrumbs'][] = ['label' => 'Voucher', 'url' => ['voucher']];
$this->params['breadcrumbs'][] = $this->title;
$optList = ArrayHelper::map(common\models\Operator::find()->where(['type' => C::OPERATOR_TYPE_LCO])->active()->asArray()->all(), 'id', 'name');
$planList = ArrayHelper::map(common\models\PlanMaster::find()->active()->asArray()->all(), 'id', 'name');
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'form-voucher', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

        <?= $form->field($model, 'operator_id', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'operator_id', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'operator_id', $optList, ['class' => 'form-control chosen-select',"prompt"=>"Select Option"]) ?>
            <?= Html::error($model, 'operator_id', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'operator_id')->end() ?>

        <?= $form->field($model, 'plan_id', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'plan_id', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'plan_id', $planList, ['class' => 'form-control chosen-select',"prompt"=>"Select Option"]) ?>
            <?= Html::error($model, 'plan_id', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'plan_id')->end() ?>

        <?= $form->field($model, 'count', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'count', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'count', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'count', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'count')->end() ?>

        <?= $form->field($model, 'opt_amount', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'opt_amount', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'opt_amount', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'opt_amount', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'opt_amount')->end() ?>

        <?= $form->field($model, 'cust_amount', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'cust_amount', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'cust_amount', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'cust_amount', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'cust_amount')->end() ?>
        <?= $form->field($model, 'expiry_date', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'expiry_date', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextInput($model, 'expiry_date', ['class' => 'form-control cal']) ?>
            <?= Html::error($model, 'expiry_date', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'expiry_date')->end() ?>


        <div class="card-footer mg-t-auto">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                    <?= Html::submitButton("Generate", ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
