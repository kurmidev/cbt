<?php

use yii\helpers\Html;
use common\ebl\Constants as C;

$j = !empty($model->ippool) ? array_keys($model->ippool) : [0];
?>
<table class="table table-striped table-bordered" id="clonetable">
    <thead>
        <tr>
            <th>Pool Name</th>
            <th>Ip Address</th>
            <th>Type</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($j as $i) { ?>
            <tr>
                <td>
                    <?= $form->field($model, 'ippool[' . $i . '][name]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeTextInput($model, 'ippool[' . $i . '][name]', ['class' => 'form-control']) ?>
                    <?= $form->field($model, 'ippool[' . $i . '][name]')->end() ?>
                </td>
                <td>
                    <?= $form->field($model, 'ippool[' . $i . '][ipaddresss]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeTextInput($model, 'ippool[' . $i . '][ipaddresss]', ['class' => 'form-control']) ?>
                    <?= $form->field($model, 'ippool[' . $i . '][ipaddresss]')->end() ?>
                </td>
                <td>
                    <?= $form->field($model, 'ippool[' . $i . '][type]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeDropDownList($model, 'ippool[' . $i . '][type]', C::$POOL_TYPES, ['class' => 'form-control', 'prompt' => "select option"]) ?>
                    <?= $form->field($model, 'ippool[' . $i . '][type]')->end() ?>
                </td>
                <td>
                    <?= $form->field($model, 'ippool[' . $i . '][status]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeDropDownList($model, 'ippool[' . $i . '][status]', C::LABEL_STATUS, ['class' => 'form-control', 'prompt' => "select option"]) ?>
                    <?= $form->field($model, 'ippool[' . $i . '][status]')->end() ?>
                </td>
                <td>
                    <?php
                    if ($i == 0) {
                        echo Html::tag('span', '', ['class' => 'fa fa-plus btn btn-success btn-xs', 'onclick' => 'addmoretablerow(this)']);
                    } else {
                        echo Html::tag('span', '', ['class' => 'fa fa-minus btn btn-danger btn-xs', "onclick" => "$(this).closest('tr').remove();"]);
                    }
                    ?>        
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>