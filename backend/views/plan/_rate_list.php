<?php

use yii\helpers\Html;

$error = [];
if (!empty($model->errors['rates'])) {
    $e = json_decode($model->errors['rates'][0], 1);
    $error = $e[$i]['rates'];
}
$rate_code_error = \yii\helpers\ArrayHelper::getColumn($error, 'rate_code');
$items = yii\helpers\ArrayHelper::map(common\models\PlanPolicy::find()->active()->asArray()->all(), 'id', 'name');
?>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th colspan="8">
                <div class="row">
                    <div class="col-sm-2">
                        <span class="label">Rate Code :</span>
                    </div>
                    <div class="col-sm-8">
                        <?= Html::activeTextInput($model, 'rates[' . $i . '][name]', ['class' => 'form-control rc reset']) ?>
                        <?= !empty($rate_code_error) ? "<div class='error help-block'>Rate code error.</div>" : "" ?>
                    </div>
                    <div class="col-sm-2">
                        <span class="drc pull-right"><i class="fa fa-remove font-weight-bold" style="font-size: 25px"></i></span>
                    </div>
                </div>
            </th>
        </tr>
        <tr>
            <th>Amount</th>
            <th>Tax</th>
            <th>Total</th>
            <th>MRP</th>
            <th>MRP Tax</th>
            <th>MRP Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($periods as $period) { ?>
            <tr>
                <td>
                    <span class="form-control dy"><?= $period['days'] ?></span>
                    <?= Html::activeHiddenInput($model, 'rates[' . $i . '][rates][' . $period['id'] . '][period_id]', ["value" => $period['id'], "class" => "reset period"]) ?>
                    <?= Html::activeHiddenInput($model, 'rates[' . $i . '][rates][' . $period['id'] . '][days]', ["value" => $period['days'], "class" => "reset period"]) ?>
                </td>
                <td>
                    <?= $form->field($model, 'rates[' . $i . '][rates][' . $period['id'] . '][free_days]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][rates][' . $period['id'] . '][free_days]', ['class' => 'form-control  reset', "value" => 0]) ?>
                    <?= $form->field($model, 'rates[' . $i . '][rates][' . $period['id'] . '][free_days]')->end() ?>
                </td>
                <td>
                    <?= $form->field($model, 'rates[' . $i . '][rates][' . $period['id'] . '][policy_id]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeDropDownList($model, 'rates[' . $i . '][rates][' . $period['id'] . '][policy_id]', $items, ['class' => 'form-control  reset', "prompt" => "Select Option"]) ?>
                    <?= $form->field($model, 'rates[' . $i . '][rates][' . $period['id'] . '][policy_id]')->end() ?>
                </td>
                <td>
                    <?= $form->field($model, 'rates[' . $i . '][rates][' . $period['id'] . '][amount]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][rates][' . $period['id'] . '][amount]', ['class' => 'form-control bcp  reset']) ?>
                    <?= !empty($error[$period['id']]['amount']) ? "<div class='error help-block'>" . $error[$period['id']]['amount'][0] . '</div>' : "" ?>
                    <?= $form->field($model, 'rates[' . $i . '][rates][' . $period['id'] . '][amount]')->end() ?>
                </td>
                <td>
                    <?= $form->field($model, 'rates[' . $i . '][rates][' . $period['id'] . '][rental]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][rates][' . $period['id'] . '][rental]', ['class' => 'form-control brd  reset']) ?>
                    <?= !empty($error[$period['id']]['rental']) ? "<div class='error help-block'>" . $error[$period['id']]['rental'][0] . "</div>" : "" ?>
                    <?= $form->field($model, 'rates[' . $i . '][rates][' . $period['id'] . '][rental]')->end() ?>
                </td>
                <td>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][rates][' . $period['id'] . '][tax]', ['class' => 'form-control bct reset', "readonly" => "true"]) ?>
                </td>
                <td>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][rates][' . $period['id'] . '][total]', ['class' => 'form-control tbct reset', "readonly" => "true"]) ?>
                </td>
                <td>
                    <?= $form->field($model, 'rates[' . $i . '][rates][' . $period['id'] . '][drp]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][rates][' . $period['id'] . '][drp]', ['class' => 'form-control mrp  reset']) ?>
                    <?= !empty($error[$period['id']]['drp']) ? "<div class='error help-block'>" . $error[$period['id']]['drp'][0] . "</div>" : "" ?>
                    <?= $form->field($model, 'rates[' . $i . '][rates][' . $period['id'] . '][drp]')->end() ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>