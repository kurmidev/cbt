<?php

use yii\helpers\Html;;

$list = common\ebl\Constants::SUBSCRIBER_ACTIVATION_CHARGES;
$cnt = !empty($model->charges) ? array_keys($model->charges) : [0];
?>

<div class="col-sm-6 mt-2">
    <div class="card">
        <div class="card-header">Charges/Payment</div>
        <div class="card-body">
            <table class="table mb30" id="proof-uploads">
                <thead>
                    <tr>
                        <th>Instrument Type</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($cnt as $i) {
                        ?>
                        <tr>
                            <td>
                                <?= Html::activeDropDownList($model, 'charges[' . $i . '][type]', $list, ['class' => 'form-control', 'prompt' => "Select Options"]) ?>
                            </td>
                            <td>
                                <?= Html::activeTextInput($model, 'charges[' . $i . '][amount]', ['class' => 'form-control']) ?>
                            </td>
                            <td>
                                <?php if ($i == 0) { ?>
                                    <?= Html::tag('span', '', ['class' => 'fa fa-plus btn btn-success btn-xs', 'id' => 'addmore']); ?>
                                <?php } else { ?>
                                    <?= Html::tag('span', '', ['class' => 'fa fa-minus btn btn-danger btn-xs', 'id' => 'addmore', 'onclick' => '$(this).closest("tr").remove();']); ?>
                                <?php } ?>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="card mt-2">
        <div class="card-header">Voucher/Coupons</div>
        <div class="card-body">
            <?= $form->field($model, 'voucher_code', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'voucher_code', ['class' => 'control-label']); ?>
            <?= Html::activeDropDownList($model, 'voucher_code', [], ['class' => 'form-control','id'=>'voucher_code', "prompt" => "Select Franchise and Plan"]) ?>
            <?= Html::error($model, 'voucher_code', ['class' => 'error help-block']) ?>
            <?= $form->field($model, 'voucher_code')->end() ?>
        </div>
    </div>
</div>