<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use common\ebl\Constants;
use common\component\Utils;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'De-Assign Plans';
$this->params['links'] = [];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_header') ?>
<?php $form = ActiveForm::begin(['id' => 'form-area', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?=
        ImsGridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'code',
                ['attribute' => 'type', 'label' => 'Type',
                    'content' => function ($model) {
                        return !empty($model->type) ? Constants::LABEL_PLAN_TYPE[$model->type] : "";
                    },
                    'filter' => Constants::LABEL_PLAN_TYPE,
                ],
                ['attribute' => 'bill_type', 'label' => 'Billing Type',
                    'content' => function ($model) {
                        return Utils::getLabels(Constants::LABEL_BILLING_TYPE, $model->bill_type);
                    },
                    'filter' => Constants::LABEL_BILLING_TYPE,
                ],
                'days',
                [
                    "label" => "Rate Code",
                    "content" => function ($model) use ($apf) {
                        $rc = !empty($model->rates) ? yii\helpers\ArrayHelper::map($model->rates, 'id', 'name') : [];
                        return Html::activeDropDownList($apf, 'rate_ids[' . $model->id . ']', $rc, ['prompt' => "Select option", "class" => "form-control"]) .
                        Html::error($apf, 'rate_ids', ['class' => 'error help-block']);
                    }
                ],
            ],
        ]);
        ?>
    </div>

    <div class="card-footer mg-t-auto">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::hiddenInput("flow", 2) ?>
                <?= Html::submitButton('Next', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>