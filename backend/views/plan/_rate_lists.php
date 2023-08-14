<?php

use yii\helpers\Html;
use common\ebl\Constants as C;

$cnt = !empty($model->rates) ? array_keys($model->rates) : [0];
?>
<table class="table table-striped table-bordered" id="clonetable">
    <thead>
        <tr>
            <th>Rate Code</th>
            <th>Amount</th>
            <th>Tax</th>
            <th>Total Amount</th>
            <th>MRP</th>
            <th>MRP Tax</th>
            <th>Total MRP</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($cnt as $i) {
            ?>
            <tr>
                <td>
                    <?= $form->field($model, 'rates[' . $i . '][name]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][name]', ['class' => 'form-control  reset', "prompt" => "Select Option"]) ?>
                    <?= Html::error($model, 'rates[' . $i . '][name]', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'rates[' . $i . '][name]')->end() ?>
                </td>
                <td>
                    <?= $form->field($model, 'rates[' . $i . '][amount]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][amount]', ['class' => 'form-control  reset', "id" => "cost_price"]) ?>
                    <?= Html::error($model, 'rates_' . $i . '_amount', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'rates[' . $i . '][amount]')->end() ?>
                </td>
                <td>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][tax]', ['class' => 'form-control bct reset', "readonly" => "true", "id" => "cost_price_tax"]) ?>
                </td>
                <td>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][total]', ['class' => 'form-control bct reset', "readonly" => "true", "id" => "cost_price_total"]) ?>
                </td>
                <td>
                    <?= $form->field($model, 'rates[' . $i . '][mrp]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][mrp]', ['class' => 'form-control  reset', "id" => "selling_price"]) ?>
                    <?= Html::error($model, 'rates_' . $i . '_mrp', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'rates[' . $i . '][mrp]')->end() ?>
                </td>
                <td>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][mrp_tax]', ['class' => 'form-control bct reset', "readonly" => "true", "id" => "selling_price_tax"]) ?>            </td>
                <td>
                    <?= Html::activeTextInput($model, 'rates[' . $i . '][mrp_total]', ['class' => 'form-control bct reset', "readonly" => "true", "id" => "selling_price_total"]) ?>
                </td>
                <td>
                    <button type="button" class="btn btn-danger" ><span class="fa fa-minus"></span></button> 
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$formula = [];
$taxObj = common\models\TaxMaster::find()->where(['like', 'applicable_on', C::TAX_APPLICABLE_PLAN]);
foreach ($taxObj->all() as $tax) {
    $formula[] = $tax->formula;
}

$js = '
        var formulas = ' . json_encode($formula) . ';
        var total = 0;
        function calculateTax(amount){
           return formulas.reduce((total,formula)=> parseFloat(eval(total)) + parseFloat(eval(formula)));
        }
   
        $(document).on("change","#cost_price",function(){
            var amount = $(this).val();
            var tax = calculateTax(amount);
            $(this).closest("tr").find("#cost_price_tax").val(Number(tax).toFixed(2));
            $(this).closest("tr").find("#cost_price_total").val(Number(parseFloat(amount) + parseFloat(tax)).toFixed(2));
        });
        $(document).on("change","#selling_price",function(){
            var amount = $(this).val();
            console.log(amount);
            var tax = calculateTax(amount);
            console.log($(this).parent().find("#selling_price_tax").val());
            $(this).closest("tr").find("#selling_price_tax").val(Number(tax).toFixed(2));
            $(this).closest("tr").find("#selling_price_total").val(Number(parseFloat(amount) + parseFloat(tax)).toFixed(2));
        });
';
$this->registerJs($js, $this::POS_READY);
?>