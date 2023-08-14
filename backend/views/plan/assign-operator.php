<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use common\ebl\Constants;
use common\component\Utils;
use yii\bootstrap\ActiveForm;
use common\ebl\Constants as C;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Assign Plans';
$this->params['links'] = [];
$this->params['breadcrumbs'][] = $this->title;

$columms = $searchModel->displayColumn(C::USERTYPE_OPERATOR);
array_pop($columms);
array_pop($columms);
array_pop($columms);
$columms = yii\helpers\ArrayHelper::merge($columms, [[
        'class' => 'yii\grid\CheckboxColumn',
        "name" => "AssignPolicyForm[operator_ids]",
        'checkboxOptions' => function ($model, $key, $index, $widget) {
            return ["value" => $model->id];
        }]]
);
?>
<?= $this->render('@app/views/layouts/_header') ?>
<?php $form = ActiveForm::begin(['id' => 'form-assign-operator', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?= Html::activeHiddenInput($apf, "flow", ["value" => 1]) ?>
        <?=
        ImsGridView::widget([
            'dataProvider' => $dataProvider,
            //  'filterModel' => $searchModel,
            'columns' => $columms
        ]);
        ?>


    </div>

    <div class="card-footer mg-t-auto">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12 text-center">

                <?= Html::submitButton('Assign', ['class' => 'btn btn-primary', 'id' => "assign"]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end() ?>
