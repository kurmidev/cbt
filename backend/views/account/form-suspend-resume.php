<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants as C;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$lbl = $account->status == C::STATUS_ACTIVE ? 'Suspend' : "Resume";
$this->title = "$lbl account {$model->username}.";
$this->params['breadcrumbs'][] = ['label' => 'Account', 'url' => ['account']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_mini_details', ['account' => $account]) ?>
<?php $form = ActiveForm::begin(['id' => 'form-renew', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p mg-t-10">
    <div class="card-header"><?= $lbl ?> connection</div>
    <div class="card-body">
        <div class="card-body">
            <?php if ($account->status == C::STATUS_ACTIVE) { ?>
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-xs-12">
                        <?= $form->field($model, 'is_refund', ['options' => ['class' => 'form-group']])->begin() ?>
                        <?= Html::activeLabel($model, 'is_refund', ['class' => 'control-label']); ?>
                        <?= Html::activeDropDownList($model, 'is_refund', C::LABEL_YESNO, ['class' => 'form-control', 'prompt' => "select options", "id" => "is_refund"]) ?>
                        <?= Html::error($model, 'is_refund', ['class' => 'error help-block']) ?>
                        <?= $form->field($model, 'is_refund')->end() ?>
                    </div>
                </div>
            <?php } ?>
            <div class="row" id="refund_data">
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
                <?= Html::submitButton("$lbl Account", ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$js = '    
                    $("#refund_data").hide();
            $(document).on("change","#is_refund",function(){    
                let var_id = this.value;
                if(var_id==1){
                    $("#refund_data").show();
                }else{
                    $("#refund_data").hide();
                }
            });

        ';

$this->registerJs($js, $this::POS_READY);
?>