<?php

use yii\helpers\Html;;
use common\ebl\Constants as C;
use yii\helpers\ArrayHelper;
use common\models\PlanMaster;

$cnt = !empty($model->addons_ids) ? array_keys($model->addons_ids) : [0];
?>

<div class="col-sm-6 mt-2">
    <div class="card">
        <div class="card-header">Add Bouquets</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-12 col-xl-12">
                    <?= $form->field($model, 'bouquet_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'bouquet_id', ['class' => 'control-label']); ?>
                    <?php
                    $list = [];
                    if (!empty($model->operator_id)) {
                        $list = ArrayHelper::map(common\models\OperatorRates::find()->andWhere(['operator_id' => $model->operator_id, 'id' => $model->bouquet_id])->all(), 'id', function ($m) {
                                    return $m->bouquet->name . "(LCO : " . ($m->amount + $m->tax) . ", MRP :" . ($m->mrp + $m->mrp_tax) . ")";
                                });
                    }
                    ?>
                    <?=
                    Html::activeDropDownList($model, 'bouquet_id', $list, ['class' => 'form-control chosen-select', 'id' => 'bouquet_id', 'prompt' => "Select Options",
                        'onchange' => '$.get( "' . Yii::$app->urlManager->createUrl('ajax/data') . '&func=Voucher&operator_id="+$("#operator_id").val()+"&bouquet_id="+$("#bouquet_id").val(), function( data ) {
                                            $( "select#voucher_code" ).html( data );
				});'
                    ])
                    ?>

                    <?= Html::error($model, 'bouquet_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'bouquet_id')->end() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-12 col-xl-12">
                    <?= $form->field($model, 'addon_ids', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'addon_ids', ['class' => 'control-label', 'label' => "Addons Bouquets"]); ?>
                    <?php
                    $list = [];
                    if (!empty($model->operator_id)) {
                        $list = ArrayHelper::map(common\models\OperatorRates::find()->andWhere(['operator_id' => $model->operator_id, 'id' => $model->addon_ids])->all(), 'id', function ($m) {
                                    return $m->bouquet->name . "(LCO : " . ($m->amount + $m->tax) . ", MRP :" . ($m->mrp + $m->mrp_tax) . ")";
                                });
                    }
                    ?>
                    <?=
                    Html::activeDropDownList($model, 'addon_ids', $list, ['class' => 'form-control chosen-select', 'id' => 'addon_ids', 'prompt' => "Select Options", "multiple" => true,
                        'onchange' => '$.get( "' . Yii::$app->urlManager->createUrl('ajax/data') . '&func=Voucher&operator_id="+$("#operator_id").val()+"&bouquet_id="+$("#addon_ids").val(), function( data ) {
                                            $( "select#voucher_code" ).html( data );
				});'
                    ])
                    ?>

                    <?= Html::error($model, 'addon_ids', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'addon_ids')->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>