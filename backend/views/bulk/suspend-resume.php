<?php

use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants as C;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('@app/views/layouts/_header') ?>
<div class="card bd-0 shadow-base widget-14 ht-100p mg-t-10">
    <div class="card-header">
        <?= $this->render('@app/views/layouts/_advanceSearch', ['search' => $search, 'model' => $searchModel]) ?>
    </div>
    <?php
    $form = ActiveForm::begin(['id' => 'plan-add-form', 'options' => ['enctype' => 'multipart/form-data']]);
    ?>
    <div class="card-body">
        <?= $form->field($model, 'is_refund', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'is_refund', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'is_refund', C::LABEL_YESNO, ['class' => 'form-control', 'prompt' => "Select Options"]) ?>
            <?= Html::error($model, 'is_refund', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'is_refund')->end() ?>

        <?= $form->field($model, 'status', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'status', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeDropDownList($model, 'status', C::LABEL_STATUS, ['class' => 'form-control', 'prompt' => "Select Options"]) ?>
            <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'is_refund')->end() ?>

        <?= $form->field($model, 'remark', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'remark', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeTextarea($model, 'remark', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'remark', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'remark')->end() ?>

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