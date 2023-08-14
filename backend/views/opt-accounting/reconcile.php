<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Add new Migration Job';
$this->params['breadcrumbs'][] = ['label' => 'Migration', 'url' => ['job']];
$this->params['breadcrumbs'][] = $this->title;
$list = [\common\ebl\jobs\ReconsilationJob::class => "Deposit Reconsilation"];
if ($type == 2) {
    $list = [\common\ebl\jobs\FinalReconsilationJob::class => "Final Reconsilation"];
}
?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'migration-form', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

        <?= $form->field($model, 'model', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($model, 'model', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?=
            Html::activeDropDownList($model, 'model', $list, ['class' => 'form-control', 'prompt' => "Select options", "id" => "model"])
            ?>
            <?= Html::error($model, 'model', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'model')->end() ?>


        <?= $form->field($model, 'file', ['options' => ['class' => "form-group"]])->begin(); ?>
        <?= Html::activeLabel($model, 'file', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= Html::activeFileInput($model, 'file', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'file', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($model, 'file')->end() ?>

        <div class="pd-10 bd rounded">
            <ul class="nav nav-gray-600 flex-column flex-sm-row" role="tablist">
                <li class="nav-item">
                    <?= implode(", ", $model->dwnFields['cols']) ?>
                    <a class="pull-right" href="<?= Yii::$app->urlManager->createUrl(["/mig/download-sample", 'rel' => implode(", ", $model->dwnFields['cols']), 'filename' => $model->dwnFields['file']]) ?>"><span class="icon ion-arrow-down-a"></span></a>
                </li>
            </ul>
        </div>


        <div class="card-footer mg-t-auto">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                    <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
