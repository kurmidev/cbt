<?php

use common\component\ImsGridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('@app/views/layouts/_header') ?>
<div class="card bd-0 shadow-base widget-14 ht-100p mg-t-10">
    <div class="card-header">
        <?= $this->render('@app/views/layouts/_advanceSearch', ['search' => $search, 'model' => $searchModel]) ?>
    </div>
    <?php
    $form = ActiveForm::begin(['id' => 'plan-add-form', 'options' => ['enctype' => 'multipart/form-data']]);
    ?>

    <?=
    ImsGridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]);
    ?>

    <div class="card-footer">
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12 col-xs-12  pd-10">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>