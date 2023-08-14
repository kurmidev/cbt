<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\ebl\Constants;

/* @var $this yii\web\View */
/* @var $model common\models\Operator */
/* @var $form yii\widgets\ActiveForm */
$label = ($type == Constants::OPERATOR_TYPE_DISTRIBUTOR ? Constants::OPERATOR_TYPE_DISTRIBUTOR_NAME : Constants::OPERATOR_TYPE_LCO_NAME);
$this->title = "Add New  $label";
$this->params['breadcrumbs'][] = ['label' => $label, 'url' => ["operator/$label"]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['id' => 'operator-form', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row">
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <h6 class="br-section-label">Company Details</h6>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'name', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'name', ['class' => 'form-control', 'maxlength' => true]) ?>
                    <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'name')->end() ?>
                </div>
            </div>

            <?php if ($type == Constants::OPERATOR_TYPE_DISTRIBUTOR) { ?>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <?= $form->field($model, 'ro_id', ['options' => ['class' => 'form-group']])->begin() ?>
                        <?= Html::activeLabel($model, 'ro_id', ['class' => 'control-label']); ?>
                        <?php
                        $optmodel = common\models\Operator::find()->defaultCondition()->andWhere(['type' => Constants::OPERATOR_TYPE_RO]);
                        $list = ArrayHelper::map($optmodel->asArray()->all(), 'id', 'name');
                        ?>
                        <?= Html::activeDropDownList($model, 'ro_id', $list, ['class' => 'form-control chosen-select', 'prompt' => 'Select Parent']) ?>
                        <?= Html::error($model, 'ro_id', ['class' => 'error help-block']) ?>
                        <?= $form->field($model, 'ro_id')->end() ?>
                    </div>
                </div>
            <?php } else if ($type == Constants::OPERATOR_TYPE_LCO) { ?>
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'ro_id', ['options' => ['class' => 'form-group']])->begin() ?>
                        <?= Html::activeLabel($model, 'ro_id', ['class' => 'control-label']); ?>
                        <?php
                        $optmodel = common\models\Operator::find()->defaultCondition()->andWhere(['type' => Constants::OPERATOR_TYPE_RO]);
                        $list = ArrayHelper::map($optmodel->asArray()->all(), 'id', 'name');
                        ?>
                        <?=
                        Html::activeDropDownList($model, 'ro_id', $list, ['class' => 'form-control chosen-select', 'prompt' => 'Select Parent',
                            'onchange' => '$.get( "' . Yii::$app->urlManager->createUrl('ajax/data') . '&func=operators&ro_id="+$("#ro_id").val()+"&type=' . Constants::OPERATOR_TYPE_DISTRIBUTOR . '", function( data ) {
                                            $( "select#distributor_id" ).html( data );
				});'
                        ])
                        ?>
                        <?= Html::error($model, 'ro_id', ['class' => 'error help-block']) ?>
                        <?= $form->field($model, 'ro_id')->end() ?>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'distributor_id', ['options' => ['class' => 'form-group']])->begin() ?>
                        <?= Html::activeLabel($model, 'distributor_id', ['class' => 'control-label']); ?>
                        <?php
                        $optmodel = common\models\Operator::find()->defaultCondition()->andWhere(['type' => Constants::OPERATOR_TYPE_DISTRIBUTOR]);
                        $list = ArrayHelper::map($optmodel->asArray()->all(), 'id', 'name');
                        ?>
                        <?= Html::activeDropDownList($model, 'distributor_id', $list, ['class' => 'form-control chosen-select', 'prompt' => 'Select Parent']) ?>
                        <?= Html::error($model, 'distributor_id', ['class' => 'error help-block']) ?>
                        <?= $form->field($model, 'distributor_id')->end() ?>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'status', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'status', Constants::LABEL_STATUS, ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'status')->end() ?>
                </div>

                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'gst_no', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'gst_no', ['class' => 'col-lg-6 col-sm-6 col-xs-6 control-label']); ?>
                    <?= Html::activeTextInput($model, 'gst_no', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'gst_no', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'gst_no')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'pan_no', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'pan_no', ['class' => 'col-lg-4 control-label']); ?>
                    <?= Html::activeTextInput($model, 'pan_no', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'pan_no', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'pan_no')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'tan_no', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'tan_no', ['class' => 'col-lg-4 control-label']); ?>
                    <?= Html::activeTextInput($model, 'tan_no', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'tan_no', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'tan_no')->end() ?>
                </div>

            </div>
            <div class="row  col-sm-12 col-lg-12 col-xs-12">
                <h6 class="br-section-label  col-sm-12 col-lg-12 col-xs-12">Configurations</h6>
                <div class="row  col-sm-12 col-lg-12 col-xs-12">
                    <div class="col-sm-6 col-lg-6 col-xs-6">
                        <?= $form->field($model, 'billing_by', ['options' => ['class' => 'form-group']])->begin() ?>
                        <?= Html::activeLabel($model, 'billing_by', ['class' => 'control-label col-sm-12 col-lg-12 col-xs-12']); ?>
                        <?php $list = \common\component\Utils::getBilledByLabels($type); ?>
                        <?= Html::activeDropDownList($model, 'billing_by', $list, ['class' => 'form-control']) ?>
                        <?= Html::error($model, 'billing_by', ['class' => 'error help-block']) ?>
                        <?= $form->field($model, 'billing_by')->end() ?>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-xs-6">
                        <?= $form->field($model, 'is_online', ['options' => ['class' => 'form-group']])->begin() ?>
                        <?= Html::activeLabel($model, 'is_online', ['class' => 'control-label  col-sm-12 col-lg-12 col-xs-12']); ?>
                        <?= Html::activeDropDownList($model, 'is_online', Constants::LABEL_YESNO, ['class' => 'form-control']) ?>
                        <?= Html::error($model, 'is_online', ['class' => 'error help-block']) ?>
                        <?= $form->field($model, 'is_online')->end() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <h6 class="br-section-label">Contact Details</h6>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'contact_person', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'contact_person', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'contact_person', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'contact_person', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'contact_person')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'email', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'email', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'email', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'email', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'email')->end() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'mobile_no', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'mobile_no', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'mobile_no', ['class' => 'form-control', 'maxlength' => 10]) ?>
                    <?= Html::error($model, 'mobile_no', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'mobile_no')->end() ?> 
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'telephone_no', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'telephone_no', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'telephone_no', ['class' => 'form-control', 'maxlength' => 10]) ?>
                    <?= Html::error($model, 'telephone_no', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'telephone_no')->end() ?> 
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'address', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'address', ['class' => 'col-sm-3 control-label']); ?>
                    <?= Html::activeTextarea($model, 'address', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'address', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'address')->end() ?> 
                </div>
                <div class="col-sm-6 col-lg-6">
                    <?= $form->field($model, 'city_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'city_id', ['class' => 'control-label']); ?>
                    <?php
                    $optmodel = common\models\Location::find()->defaultCondition()->andWhere(['type' => Constants::LOCATION_CITY])->active();
                    $list = ArrayHelper::map($optmodel->asArray()->all(), 'id', 'name');
                    ?>
                    <?= Html::activeDropDownList($model, 'city_id', $list, ['class' => 'form-control chosen-select', 'prompt' => 'Select City']) ?>
                    <?= Html::error($model, 'city_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'city_id')->end() ?>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <?= $form->field($model, 'designation_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'designation_id', ['class' => 'control-label']); ?>
                    <?php
                    $optmodel = common\models\Designation::find()->defaultCondition()->excludeSysDef()->active();
                    $list = ArrayHelper::map($optmodel->asArray()->all(), 'id', 'name');
                    ?>
                    <?= Html::activeDropDownList($model, 'designation_id', $list, ['class' => 'form-control chosen-select', 'prompt' => 'Select Designation']) ?>
                    <?= Html::error($model, 'designation_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'designation_id')->end() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body row">
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= $form->field($model, 'username', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'username', ['class' => 'col-sm-8 control-label']); ?>
            <?= Html::activeTextInput($model, 'username', ['class' => 'form-control', 'maxlength' => true]) ?>
            <?= Html::error($model, 'username', ['class' => 'error help-block']) ?>
            <?= $form->field($model, 'username')->end() ?>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?= $form->field($model, 'password', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'password', ['class' => 'col-lg-6 col-sm-6 col-xs-6 control-label']); ?>
            <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'password', ['class' => 'error help-block']) ?>
            <?= $form->field($model, 'password')->end() ?>
        </div>
    </div>
    <div class="card-footer mg-t-auto">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>