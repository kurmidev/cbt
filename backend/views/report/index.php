<?php

use common\component\ImsGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('@app/views/layouts/_header') ?>
<?= $this->render('@app/views/layouts/_advanceSearch', ['search' => $search, 'model' => $searchModel]) ?>

<?=

ImsGridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
]);
?>