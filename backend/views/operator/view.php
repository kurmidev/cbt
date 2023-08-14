<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\data\ArrayDataProvider;

$this->title = $model->name . "(" . $model->code . ")";
$actionUrl = $model->type == common\ebl\Constants::OPERATOR_TYPE_DISTRIBUTOR ? 'distributor' : 'franchise';
$this->params['links'] = [
    ['title' => 'EDIT ' . $this->title, 'url' => \Yii::$app->urlManager->createUrl(["operator/update-" . strtolower($actionUrl), 'id' => $model->id]), 'class' => 'fa fa-edit'],
];

$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_header') ?>

<div class="br-pagebody">
    <div class="tab-content">
        <div class="tab-pane fade active show">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="tab-content">
                        <?php
                        echo Tabs::widget([
                            'items' => [
                                [
                                    'label' => 'Wallet',
                                    'content' => $this->render('_wallet', ['dataProvider' => new ArrayDataProvider([
                                            'allModels' => $w_provider,
                                            'key' => 'id',
                                            'pagination' => [
                                                'pageSize' => 20,
                                            ],
                                                ])
                                        , 'id' => $model->id, 'actionUrl' => $actionUrl]),
                                ],
                                [
                                    'label' => 'Alloted Bouquet',
                                    'content' => $this->render('_plans', ['dataProvider' => new ArrayDataProvider([
                                            'allModels' => $p_provider,
                                            'key' => 'id',
                                            'pagination' => [
                                                'pageSize' => 20,
                                            ],
                                                ]), 'id' => $model->id, 'actionUrl' => $actionUrl]),
                                ],
                                [
                                    'label' => 'Alloted IPs',
                                    //'content' => $this->render('_staticip', ['dataProvider' => $w_staicip, 'id' => $model->id, 'actionUrl' => $actionUrl]),
                                    'content' => $this->render('_staticip', ['dataProvider' => new ArrayDataProvider([
                                            'allModels' => $w_staicip,
                                            'key' => 'id',
                                            'pagination' => [
                                                'pageSize' => 20,
                                            ],
                                                ]), 'id' => $model->id, 'actionUrl' => $actionUrl]),
                                ],
                                [
                                    'label' => 'Details',
                                    'content' => $this->render('_details', ['model' => $model]),
                                ],
                            ],
                            'options' => ['tag' => 'div'],
                            'itemOptions' => ['tag' => 'div'],
                            'headerOptions' => ['class' => 'tab-pane'],
                            'clientOptions' => ['collapsible' => false],
                        ]);
                        ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/confirmation.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$js = '
$(document).on("ready pjax:success", function() {

        $(".ressus").on("click",function(){
                var id = $(this).attr("rec");
                var status = $(this).attr("status");
              
                bootbox.confirm("Are you sure, you want to delete the renewal entry?", function(result) {
                    if(result){
                          $.ajax({
                            url: "' . Yii::$app->urlManager->createUrl('operator/delete-wallet') . '",
                            type: "post",
                            dataType: "html",
                            data: "id="+id,
                            success: function (data, status) {
                               bootbox.alert(data);
                               $.pjax.reload({container:"#opt-wallet-list"});  
                            },
                            error: function (xhr, desc, err) {
                                console.log(xhr);
                                console.log("Desc: " + desc + "\nErr:" + err);
                            }
                        });
                     }
                }); 
             });
             });';

$this->registerJs($js, $this::POS_READY);
?>