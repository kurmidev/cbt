<?php

use yii\bootstrap\Html;
use common\component\ImsGridView;
use common\ebl\Constants as C;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Add/Change MRP of Static IP Plans';
$this->params['links'] = [];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_header') ?>
<?php $form = ActiveForm::begin(['id' => 'form-assignplan', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?=
        ImsGridView::widget([
            'dataProvider' => $model,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                "staticip.name",
                "staticip.code",
                "staticip.days",
                [
                    "header" => 'Price(A)',
                    'content' => function ($model) {
                        return $model->amount;
                    }
                ],
                [
                    "header" => 'Tax(B)',
                    'content' => function ($model) {
                        return $model->tax;
                    }
                ],
                [
                    "header" => 'Total(A+B)',
                    'content' => function ($model) {
                        return ($model->amount + $model->tax);
                    }
                ],
                [
                    "header" => 'MRP Price(A)',
                    'content' => function ($model) {
                        return Html::textInput("mrp[" . $model->id . "]", $model->mrp, ['class' => 'form-control mrpa']);
                    }
                ],
                [
                    "header" => 'MRP Tax(B)',
                    'content' => function ($model) {
                        return Html::tag("div", $model->mrp_tax, ['class' => "form-control mrpb"]);
                    }
                ],
                [
                    "header" => 'MRP(A+B)',
                    'content' => function ($model) {
                        return Html::tag("div", ($model->mrp + $model->mrp_tax), ['class' => "form-control mrpc"]);
                    }
                ],
            ],
        ]);
        ?>
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
<?php
$formula = [];
$taxObj = common\models\TaxMaster::find()->where(['like', 'applicable_on', common\ebl\Constants::TAX_APPLICABLE_PLAN]);
foreach ($taxObj->all() as $tax) {
    $formula[] = $tax->formula;
}

$js = 'var formulas = ' . json_encode($formula) . ';          '
        . '$(".mrpa").on("change",function(){
            var a  = $(this).val();
            var tax = calculateTax(parseFloat(a));
            var total = parseFloat(a) + parseFloat(tax);
            $(".mrpc").html(total);
            $(".mrpb").html(tax);
        }) ';


$this->registerJs($js, $this::POS_END);
?>