<?php

use yii\helpers\Html;
use common\ebl\Constants as C;

$list = \yii\helpers\ArrayHelper::map(common\models\IpPoolList::find()->freeIps()->asArray()->all(), 'ipaddress', 'ipaddress');
?>
<div class="col-sm-6 mb-2">
    <div class="card">
        <div class="card-header">Device Allocation</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'device_details[device_id]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'device_details[device_id]', ['class' => 'control-label', 'label' => "Device"]); ?>
                    <?= Html::activeDropDownList($model, 'device_details[device_id]', [], ['class' => 'form-control chosen-select', 'prompt' => "Select options","id"=>"device_id"]) ?>
                    <?= Html::error($model, 'device_details[device_id]', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'device_details[device_id]')->end() ?>
                </div>
                <div class="col-sm-12">
                    <?= $form->field($model, 'device_details[mrp]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'device_details[mrp]', ['class' => 'control-label', 'label' => "MRP Price"]); ?>
                    <?= Html::activeTextInput($model, 'device_details[mrp]', ['class' => 'form-control', 'maxlength' => 10]) ?>
                    <?= Html::error($model, 'device_details[mrp]', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'device_details[mrp]')->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>