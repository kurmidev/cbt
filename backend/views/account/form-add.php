<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $planmodel common\models\Plans */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Add New Customer';
$this->params['breadcrumbs'][] = ['label' => 'Account', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card  bd-0 shadow-base widget-14 ht-100p pd-10">
    <?php
    $form = ActiveForm::begin(['id' => 'plan-add-form', 'options' => ['enctype' => 'multipart/form-data']]);
    ?>
    <?= $this->render('_add_account', ['model' => $model, 'form' => $form]) ?>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
