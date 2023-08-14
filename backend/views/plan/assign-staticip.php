<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use common\ebl\Constants as C;
use common\component\Utils as U;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Assign Static Ip';
$this->params['links'] = [];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_header') ?>
<?php $form = ActiveForm::begin(['id' => 'form-staticip', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">

        <?= $form->field($apf, 'operator_ids', ['options' => ['class' => 'form-group']])->begin() ?>
        <?= Html::activeLabel($apf, 'operator_ids', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label', 'labels' => "Distributor/Franchise"]); ?>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <?php
            $list = \yii\helpers\ArrayHelper::map(common\models\Operator::find()->active()->all(), 'id', 'name', function($op) {
                        return !empty($op->distributor) ? $op->distributor->name : ($op->mso ? $op->mso->name : "");
                    });
            ?>
            <?= Html::activeDropDownList($apf, 'operator_ids', $list, ['class' => 'form-control chosen-select', 'multiple' => 'multiple']) ?>
            <?= Html::error($apf, 'operator_ids', ['class' => 'error help-block']) ?>
        </div>
        <?= $form->field($apf, 'operator_ids')->end() ?>


        <?php Pjax::begin(); ?>
        <?=
        ImsGridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'code',
                'description',
                [
                    "label" => "Rate Code",
                    "content" => function ($model) use($apf) {
                        $rc = !empty($model->rates) ? yii\helpers\ArrayHelper::map($model->rates, 'id', 'name') : [];
                        return Html::activeDropDownList($apf, 'rate_ids[' . $model->id . ']', $rc, ['prompt' => "Select option", "class" => "form-control"]);
                    }
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>

    <div class="card-footer mg-t-auto">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::submitButton('Assign', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>