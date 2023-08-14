<?php
/* @var $this yii\web\View */

use yii\widgets\Pjax;
use backend\component\widgets\CustomerCount;
use backend\component\widgets\Renewals;
use backend\component\widgets\Collections;
use backend\component\widgets\Crm;
use backend\component\widgets\TopPlans;
use backend\component\widgets\PlanSummary;
use backend\component\widgets\OperatorPlans;
use backend\component\widgets\ExpiringCustomer;
use backend\component\widgets\CrmGraph;

//use app\components\widget\OnlineWidget;
//use app\components\widget\ExpiryWidget;
//use app\components\widget\RevenueWidget;
//use app\components\widget\NasSubscriber;
//use app\components\widget\OnlineGraph;

$this->title = 'DASHBOARD';
?>
<?php Pjax::begin(['id' => 'topband']); ?>
<div class="br-pagebody pd-x-20 pd-sm-x-30">

    <div class="row no-gutters widget-1 shadow-base ">
        <div class="col-sm-6 col-lg-3">
            <?= CustomerCount::widget() ?> 
        </div><!-- col-3 -->

        <div class="col-sm-6 col-lg-3 mg-t-1 mg-sm-t-0">
            <?= Renewals::widget() ?>
        </div><!-- col-3 -->

        <div class="col-sm-6 col-lg-3 mg-t-1 mg-lg-t-0">
            <?= Collections::widget() ?>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-lg-3 mg-t-1 mg-lg-t-0">
            <?= Crm::widget() ?>
        </div><!-- col-3 -->
    </div><!-- row -->

    <div class="row no-gutters  ">
        <div class="col-sm-6 col-lg-6 mg-t-10-force">
            <?= TopPlans::widget() ?>
        </div>

        <div class="col-sm-6 col-lg-6 mg-t-10-force pd-l-5-force">
            <?= PlanSummary::widget() ?>
        </div>
    </div>
    <div class="row no-gutters  ">
        <div class="col-sm-6 col-lg-6 mg-t-10-force pd-l-5-force">
            <?= OperatorPlans::widget() ?>
        </div>
        <div class="col-sm-6 col-lg-6 mg-t-10-force pd-l-5-force">
            <?= ExpiringCustomer::widget() ?>
        </div>
    </div>

    <?= CrmGraph::widget() ?>

</div>
<?php Pjax::end(); ?>

<?php
$js = 'function refresh() {
    console.log(new Date());
     $.pjax.reload({container:"body"});
     
 }
 setInterval(refresh, 30000); // restart the function every 30 seconds
 ';

$this->registerJs($js, $this::POS_READY);
?>
