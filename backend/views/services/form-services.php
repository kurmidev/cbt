<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\ebl\Constants as C;
use common\models\Broadcaster;
use common\models\Genre;
use common\models\Language;
use common\models\Services;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = empty($model->id) ? 'Add new Service' : 'Update Service ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['plan']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['id' => 'form-services', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-4 col-sm-4 col-xs-4">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'name', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'name')->end() ?>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-4">
                    <?= $form->field($model, 'service_type', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'service_type', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'service_type', C::SERVICE_TYPE, ['class' => 'form-control', 'prompt' => 'select option']) ?>
                    <?= Html::error($model, 'service_type', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'service_type')->end() ?>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-4">
                    <?= $form->field($model, 'type', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'type', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'type', C::LABEL_HDSD, ['class' => 'form-control', 'prompt' => 'select option']) ?>
                    <?= Html::error($model, 'type', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'type')->end() ?>
                </div>
                
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
            <div class="col-lg-4 col-sm-4 col-xs-4">
                    <?= $form->field($model, 'is_alacarte', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'is_alacarte', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'is_alacarte', C::LABEL_YESNO, ['class' => 'form-control', 'prompt' => 'select option']) ?>
                    <?= Html::error($model, 'is_alacarte', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'is_alacarte')->end() ?>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-4">
                    <?= $form->field($model, 'is_fta', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'is_fta', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'is_fta', C::LABEL_YESNO, ['class' => 'form-control', 'prompt' => 'select option']) ?>
                    <?= Html::error($model, 'is_fta', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'is_fta')->end() ?>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-4">
                    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'status', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'status', C::LABEL_STATUS, ['class' => 'form-control', 'prompt' => 'select option']) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'status')->end() ?>
                </div>
                
            </div>
            <div class="row">
            <div class="col-lg-4 col-sm-4 col-xs-4">
                    <?= $form->field($model, 'language_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'language_id', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'language_id', ArrayHelper::map(Language::find()->active()->all(), 'id','name'), ['class' => 'form-control', 'prompt' => 'select option']) ?>
                    <?= Html::error($model, 'language_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'language_id')->end() ?>
                </div>    
                <div class="col-lg-4 col-sm-4 col-xs-4">
                    <?= $form->field($model, 'genre_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'genre_id', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'genre_id', ArrayHelper::map(Genre::find()->active()->all(), 'id','name'), ['class' => 'form-control', 'prompt' => 'select option']) ?>
                    <?= Html::error($model, 'genre_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'genre_id')->end() ?>
                </div>    
                <div class="col-lg-4 col-sm-4 col-xs-4">
                    <?= $form->field($model, 'broadcaster_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'broadcaster_id', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'broadcaster_id', ArrayHelper::map(Broadcaster::find()->active()->all(), 'id','name'), ['class' => 'form-control', 'prompt' => 'select option']) ?>
                    <?= Html::error($model, 'broadcaster_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'broadcaster_id')->end() ?>
                </div>
                </div>
            <div class="row">
                <div class="col-lg-4 col-sm-4 col-xs-4">
                    <?= $form->field($model, 'rate', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'rate', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'rate', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'rate', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'rate')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'description', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'description', ['class' => 'control-label']); ?>
                    <?= Html::activeTextarea($model, 'description',['class' => 'form-control']) ?>
                    <?= Html::error($model, 'description', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'description')->end() ?>
                </div>
            </div>
            <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <h6 class="br-section-label p-4">Plugin Details </h6>
                <table class="table table-striped table-bordered"  id="clonetable">
                    <thead>
                        <tr>
                            <th>Plugin</th>
                            <th>Plugin Code</th>
                            <th>Other Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($plugins as $plugin) {
                            ?>
                            <tr>
                                <td>
                                    <?=$plugin->name?>
                                    <?= Html::activeHiddenInput($model, 'cas_code_mapping[' . $plugin->id . '][plugin_id]', ['value'=>$plugin->id]) ?>
                                </td>
                                <td>
                                    <?= $form->field($model, 'cas_code_mapping[' . $plugin->id . '][plugin_code]', ['options' => ['class' => 'form-group']])->begin() ?>
                                    <?= Html::activeTextInput($model, 'cas_code_mapping[' . $plugin->id . '][plugin_code]', ['class' => 'form-control  reset', "prompt" => "Select Option"]) ?>
                                    <?= Html::error($model, 'cas_code_mapping[' . $plugin->id. '][plugin_code]', ['class' => 'error help-block']) ?>
                                    <?= $form->field($model, 'cas_code_mapping[' . $plugin->id. '][plugin_code]')->end() ?>
                                </td>
                                <td>
                                    <?= $form->field($model, 'cas_code_mapping[' . $plugin->id . '][other_codes]', ['options' => ['class' => 'form-group']])->begin() ?>
                                    <?= Html::activeTextInput($model, 'cas_code_mapping[' . $plugin->id . '][other_codes]', ['class' => 'form-control  reset', "id" => "cost_price"]) ?>
                                    <?= Html::error($model, 'cas_code_mapping' . $plugin->id . 'other_codes', ['class' => 'error help-block']) ?>
                                    <?= $form->field($model, 'cas_code_mapping[' . $plugin->id . '][other_codes]')->end() ?>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                 <h6 class="br-section-label p-4">Assets</h6>
                 <div class="col-lg12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'service_mapping', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeDropDownList($model, 'service_mapping',ArrayHelper::map(Services::find()->active()->andWhere(['service_type'=>C::SERVICE_TYPE_CHANNEL])->all(),'id','name'),['class' => 'form-control chosen-select', 'prompt' => "Select Options" ,"multiple"=>true]) ?>
                    <?= Html::error($model, 'service_mapping', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'service_mapping')->end() ?>
                </div>
            </div>
                
            </div>
        </div>
    </div>
   
    <div class="card-footer mg-t-auto">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::activeHiddenInput($model, 'id') ?>
                <?= Html::submitButton(empty($model->id) ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>