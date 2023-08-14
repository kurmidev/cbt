<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */


$this->title = "Terminate account {$model->username}.";
$this->params['breadcrumbs'][] = ['label' => 'Account', 'url' => ['account']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_mini_details', ['account' => $account]) ?>
<?php $form = ActiveForm::begin(['id' => 'form-renew', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p mg-t-10">
    <div class="card-header">Terminate connection</div>
    <div class="card-body">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <?php if (!empty($account->activePlans)) { ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Plan Name</th>
                                    <th>Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Left Days</th>
                                    <th>Refund Franchise Amount</th>
                                    <th>Refund MRP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($account->activePlans as $plans) { ?>
                                    <tr>
                                        <td><?= $plans->plan->name ?></td>
                                        <td><?= $plans->planTypeLabel ?></td>
                                        <td><?= $plans->start_date ?></td>
                                        <td><?= $plans->end_date ?></td>
                                        <td><?= $plans->leftDays ?></td>
                                        <td><?= $plans->refundAmount ?></td>
                                        <td><?= $plans->refundMrp ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'remark', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'remark', ['class' => 'control-label']); ?>
                    <?= Html::activeTextarea($model, 'remark', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'remark', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'remark')->end() ?>
                </div>
            </div>

        </div>

    </div>
    <div class="card-footer mg-t-auto">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12 col-sm-offset-12 text-center">
                <?= Html::submitButton("Terminate Account", ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>