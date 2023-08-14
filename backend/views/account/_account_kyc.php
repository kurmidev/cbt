<?php
use yii\bootstrap\Html;

?>

<div class="col-sm-6">
    <div class="card">
        <div class="card-header">KYC Details</div>
        <div class="card-body">
            <table class="table mb30" id="proof-uploads">
                <thead>
                    <tr>
                        <th>Proof</th>
                        <th>File</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            SAF FORM
                            <?= Html::activeHiddenInput($model, 'proof[type][0]', ['value' => 'SAFORM']) ?>
                        </td>
                        <td>
                            <?= $form->field($model, 'proof[file][0]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <?= $form->field($model, 'proof[type][1]')->dropDownList(['PHOTOID' => 'Photo Proof', 'ADDRSID' => 'Address'])->label('') ?>
                        </td>
                        <td>
                            <?= $form->field($model, 'proof[file][1]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
                        </td>
                        <td><?= Html::tag('span', '', ['class' => 'fa fa-plus btn btn-success btn-xs', 'id' => 'addmore']); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>