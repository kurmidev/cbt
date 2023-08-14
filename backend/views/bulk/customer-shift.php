<?php

use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\models\Operator;
use common\models\Location;
use common\ebl\Constants as C;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;

$optList = \yii\helpers\ArrayHelper::map(Operator::find()->where(['type' => C::USERTYPE_OPERATOR])->active()->asArray()->all(), 'id', 'name');
$buildingList = \yii\helpers\ArrayHelper::map(Location::find()->where(['type' => C::LOCATION_BUILDING])->active()->asArray()->all(), 'id', 'name');
?>

<?= $this->render('@app/views/layouts/_header') ?>
<div class="card bd-0 shadow-base widget-14 ht-100p mg-t-10">
    <div class="card-header">
        <?= $this->render('@app/views/layouts/_advanceSearch', ['search' => $search, 'model' => $searchModel]) ?>
    </div>
    <?php
    $form = ActiveForm::begin(['id' => 'subscriber-shift-form', 'options' => ['enctype' => 'multipart/form-data']]);
    ?>
    <div class="card-body">
        <?= $form->field($model, 'operator_id', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'operator_id', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'operator_id', $optList, ['class' => 'form-control chosen-select', 'prompt' => "Select Options"]) ?>
            <?= Html::error($model, 'operator_id', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'operator_id')->end() ?>

        <?= $form->field($model, 'building_id', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'building_id', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'building_id', $buildingList, ['class' => 'form-control chosen-select', 'prompt' => "Select Options"]) ?>
            <?= Html::error($model, 'building_id', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'building_id')->end() ?>


    </div>
    <?=
    ImsGridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]);
    ?>

    <div class="card-footer">
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12 col-xs-12  pd-10">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>