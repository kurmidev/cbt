<?php

use yii\helpers\Html;
use common\ebl\Constants as C;

$list = \yii\helpers\ArrayHelper::map(common\models\IpPoolList::find()->freeIps()->asArray()->all(), 'ipaddress', 'ipaddress');
?>
<div class="col-sm-6 mb-2">
    <div class="card">
        <div class="card-header">Static IP Address Allocation</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'ip_details[ipaddress]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'ip_details[ipaddress]', ['class' => 'control-label','label'=>"Ip Address"]); ?>
                    <?= Html::activeDropDownList($model, 'ip_details[ipaddress]', $list, ['class' => 'form-control chosen-select','prompt'=>"Select options"]) ?>
                    <?= Html::error($model, 'ip_details[ipaddress]', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'ip_details[ipaddress]')->end() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'ip_details[start_date]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'ip_details[start_date]', ['class' => 'control-label','label'=>"Start Date"]); ?>
                    <?= Html::activeTextInput($model, 'ip_details[start_date]', ['class' => 'form-control cal', 'readonly' => TRUE]) ?>
                    <?= Html::error($model, 'ip_details[start_date]', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'ip_details[start_date]')->end() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'ip_details[end_date]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'ip_details[end_date]', ['class' => 'control-label','label'=>"End Date"]); ?>
                    <?= Html::activeTextInput($model, 'ip_details[end_date]', ['class' => 'form-control cal', 'readonly' => TRUE]) ?>
                    <?= Html::error($model, 'ip_details[end_date]', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'ip_details[end_date]')->end() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'ip_details[amount]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'ip_details[amount]', ['class' => 'control-label', 'label' => "Franchise Price"]); ?>
                    <?= Html::activeTextInput($model, 'ip_details[amount]', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'ip_details[amount]', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'ip_details[amount]')->end() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'ip_details[mrp]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'ip_details[mrp]', ['class' => 'control-label', 'label' => "MRP Price"]); ?>
                    <?= Html::activeTextInput($model, 'ip_details[mrp]', ['class' => 'form-control', 'maxlength' => 10]) ?>
                    <?= Html::error($model, 'ip_details[mrp]', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'ip_details[mrp]')->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>