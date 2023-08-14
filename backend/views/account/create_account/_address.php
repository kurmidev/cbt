<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Operator;
use common\ebl\Constants as C;
use common\models\Location;
?>
<div class="col-sm-6 mb-2">
    <div class="card">
        <div class="card-header">Address Details</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'operator_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'operator_id', ['class' => 'control-label', 'label' => 'Franchise']); ?>
                    <?php
                    $list = ArrayHelper::map(Operator::find()->defaultCondition()->andWhere(['type' => C::OPERATOR_TYPE_LCO])->asArray()->all(), 'id', 'name');
                    ?>
                    <?=
                    Html::activeDropDownList($model, 'operator_id', $list, ['class' => 'form-control chosen-select', 'id' => 'operator_id', 'prompt' => "Select Options",
                        'onchange' => '$.get( "' . Yii::$app->urlManager->createUrl('ajax/data') . '&func=PlanRate&operator_id="+$(this).val()+"&plan_type=' . C::PLAN_TYPE_BASE . '", function( data ) {
                                            $( "select#bouquet_id" ).html( data );
                                            $("select#bouquet_id").trigger("chosen:updated");
				});$.get( "' . Yii::$app->urlManager->createUrl('ajax/data') . '&func=AddonsRate&operator_id="+$(this).val(), function( data ) {
                                            $( "select#addon_ids" ).html( data );
                                            $("select#addon_ids").trigger("chosen:updated");
				});$.get( "' . Yii::$app->urlManager->createUrl('ajax/data') . '&func=FreeDevice&operator_id="+$(this).val(), function( data ) {
                                            $( "select#device_id" ).html( data );
                                            $("select#device_id").trigger("chosen:updated");
				});'
                    ])
                    ?>
                    <?= Html::error($model, 'operator_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'operator_id')->end() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'area_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'area_id', ['class' => 'control-label']); ?>
                    <?php
                    $query = Location::find()->defaultCondition()->andWhere(['type' => C::LOCATION_AREA]);
                    $list = ArrayHelper::map($query->asArray()->all(), 'id', 'name');
                    ?>
                    <?=
                    Html::activeDropDownList($model, 'area_id', $list, ['class' => 'form-control', 'id' => 'area_id', "prompt" => "Select Area",
                        'onchange' => '$.get( "' . Yii::$app->urlManager->createUrl('ajax/data') . '&func=Location&type=' . C::LOCATION_ROAD . '&area_id="+$(this).val(), function( data ) {
                                        $( "select#road_id" ).html( data );
				});'])
                    ?>
                    <?= Html::error($model, 'area_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'area_id')->end() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'road_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'road_id', ['class' => 'control-label']); ?>
                    <?php
                    $list = ["" => "Select Area first"];
                    if ($model->area_id) {
                        $list = ArrayHelper::map(Location::find()->defaultCondition()
                                                ->andWhere(['type' => C::LOCATION_ROAD])
                                                ->andFilterWhere(['area_id' => $model->area_id])
                                                ->asArray()->all(), 'id', 'name');
                    }
                    ?>
                    <?=
                    Html::activeDropDownList($model, 'road_id', $list, ['class' => 'form-control', 'id' => 'road_id',
                        'onchange' => '$.get( "' . Yii::$app->urlManager->createUrl('ajax/data') . '&func=Location&type=' . C::LOCATION_BUILDING . '&road_id="+$(this).val(), function( data ) {
                                            $( "select#building_id" ).html( data );
				});'
                    ])
                    ?>
                    <?= Html::error($model, 'road_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'road_id')->end() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'building_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'building_id', ['class' => 'control-label']); ?>
                    <?php
                    $list = ["" => "Select Road first"];
                    if ($model->road_id) {
                        $list = ArrayHelper::map(Location::find()->defaultCondition()->andWhere(['type' => C::LOCATION_BUILDING])
                                                ->andFilterWhere(['road_id' => $model->road_id])->asArray()->all(), 'id', 'name');
                    }
                    ?>
                    <?= Html::activeDropDownList($model, 'building_id', $list, ['class' => 'form-control', 'id' => 'building_id'])
                    ?>
                    <?= Html::error($model, 'building_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'building_id')->end() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'address', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'address', ['class' => 'control-label']); ?>
                    <?= Html::activeTextarea($model, 'address', ['class' => 'form-control', 'maxlength' => true]) ?>
                    <?= Html::error($model, 'address', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'address')->end() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'bill_address', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'bill_address', ['class' => 'control-label']); ?>
                    <?= Html::activeTextarea($model, 'bill_address', ['class' => 'form-control', 'maxlength' => true]) ?>
                    <?= Html::error($model, 'bill_address', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'bill_address')->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>