<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use common\component\ImsGridView;
use common\component\Utils as U;
use common\ebl\Constants as C;
?>

<div class="row no-gutters widget-1 shadow-base">
    <div class="col-sm-6 col-lg-3">
        <?= $this->render('./dashboard/accounting', ['account' => $model]) ?>
    </div>
    <div class="col-sm-6 col-lg-3 mg-t-1 mg-sm-t-0">
        <?= $this->render('./dashboard/complaint', ['account' => $model]) ?>
    </div>
    <div class="col-sm-6 col-lg-3 mg-t-1 mg-lg-t-0">
        <?= $this->render('./dashboard/current_plan', ['account' => $model]) ?>
    </div>
    <div class="col-sm-6 col-lg-3 mg-t-1 mg-lg-t-0">
        <?= $this->render('./dashboard/collections', ['account' => $model]) ?>
    </div>
</div>

<div class="row row-sm mg-t-20">
    <div class="col-lg-6">
        <div class="widget-2">
            <div class="card shadow-base overflow-hidden">
                <div class="card-header">
                    <h6 class="card-title">Contact Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label">Name</label>
                            <span class="form-control"><?= $model->customer->name ?></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="control-label">Username</label>
                            <span class="form-control"><?= $model->username ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label">Gender</label>
                            <span class="form-control"><?= $model->customer->genderName ?></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="control-label">DOB</label>
                            <span class="form-control"><?= $model->customer->dob ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label">Mobile No.</label>
                            <span class="form-control"><?= $model->customer->mobile_no ?></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="control-label">Phone No.</label>
                            <span class="form-control"><?= $model->customer->phone_no ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label">Email</label>
                            <span class="form-control"><?= $model->customer->email ?></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="control-label">Connection Type</label>
                            <span class="form-control"><?= $model->customer->connectionType ?></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="widget-2">
            <div class="card shadow-base overflow-hidden">
                <div class="card-header">
                    <h6 class="card-title">Address Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label">Franchise</label>
                            <span class="form-control"><?= $model->customer->name ?></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="control-label">Area</label>
                            <span class="form-control"><?= $model->road->area->name ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label">Road</label>
                            <span class="form-control"><?= $model->road->name ?></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="control-label">Building</label>
                            <span class="form-control"><?= $model->building->name ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label">Address.</label>
                            <span class="form-control"><?= $model->customer->address ?></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="control-label">Bill Address.</label>
                            <span class="form-control"><?= $model->customer->billing_address ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<div class="row row-sm mg-t-20">
    <div class="col-lg-6">
        <div class="widget-2">
            <div class="card shadow-base overflow-hidden">
                <div class="card-header">
                    <h6 class="card-title">Account Debits</h6>
                </div>

                <?php Pjax::begin(['id' => 'opt-wallet-list']); ?>

                <?=
                ImsGridView::widget([
                    'dataProvider' => $dr,
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'actionOn', 'label' => 'Trans Date',
                            'content' => function ($model) {
                                return Yii::$app->formatter->asDatetime($model->actionOn, 'php:d M Y H:i');
                            }
                        ],
                        [
                            'attribute' => 'actiondoneby', 'label' => 'Trans By',
                            'content' => function ($model) {
                                return $model->actionBy;
                            }
                        ],
                        [
                            'attribute' => 'type',
                            'content' => function ($model) {
                                return U::getLabels(U::optTransactionLabel(), $model->trans_type);
                            },
                            'filter' => U::optTransactionLabel(),
                        ],
                        [
                            'attribute' => 'amount',
                            'content' => function ($data) {
                                return $data['amount'];
                            }
                        ],
                        [
                            'attribute' => 'tax',
                            'content' => function ($data) {
                                return $data['tax'];
                            }
                        ],
                        [
                            'label' => "Total",
                            'content' => function ($data) {
                                return $data['amount'] + $data['tax'];
                            }
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="widget-2">
            <div class="card shadow-base overflow-hidden">
                <div class="card-header">
                    <h6 class="card-title">Account Credit</h6>
                </div>

                <?php Pjax::begin(['id' => 'opt-wallet-list']); ?>

                <?=
                ImsGridView::widget([
                    'dataProvider' => $cr,
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'actionOn', 'label' => 'Trans Date',
                            'content' => function ($model) {
                                return Yii::$app->formatter->asDatetime($model->actionOn, 'php:d M Y H:i');
                            }
                        ],
                        [
                            'attribute' => 'actiondoneby', 'label' => 'Trans By',
                            'content' => function ($model) {
                                return $model->actionBy;
                            }
                        ],
                        [
                            'attribute' => 'type',
                            'content' => function ($model) {
                                return U::getLabels(U::optTransactionLabel(), $model->trans_type);
                            },
                            'filter' => U::optTransactionLabel(),
                        ],
                        [
                            'attribute' => 'amount',
                            'content' => function ($data) {
                                return $data['amount'];
                            }
                        ],
                        [
                            'attribute' => 'tax',
                            'content' => function ($data) {
                                return $data['tax'];
                            }
                        ],
                        [
                            'label' => "Total",
                            'content' => function ($data) {
                                return $data['amount'] + $data['tax'];
                            }
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
</div>


<div class="row row-sm mg-t-20">
    <div class="col-lg-6">
        <div class="widget-2">
            <div class="card shadow-base overflow-hidden">
                <div class="card-header">
                    <h6 class="card-title">Bouquet Subscribed</h6>
                </div>

                <?php Pjax::begin(['id' => 'subscribed_plans']); ?>

                <?=
                ImsGridView::widget([
                    'dataProvider' => $sp,
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'actionOn', 'label' => 'Trans Date',
                            'content' => function ($model) {
                                return Yii::$app->formatter->asDatetime($model->actionOn, 'php:d M Y H:i');
                            }
                        ],
                        [
                            'attribute' => 'actiondoneby', 'label' => 'Trans By',
                            'content' => function ($model) {
                                return $model->actionBy;
                            }
                        ],
                        [
                            'attribute' => 'bouquet_id',
                            "label"=>"Bouquet",
                            'content' => function ($model) {
                                return $model->bouquet_name;
                            },
                        ],
                        [
                            'attribute' => "bouquet_type",
                            'content' => function ($data) {
                                return C::LABEL_PLAN_TYPE[$data['bouquet_type']];
                            }
                        ],
                        [
                            'attribute' => "status",
                            'content' => function ($data) {
                                return !empty(C::LABEL_SUBSCRIBER_STATUS[$data['status']]) ? C::LABEL_SUBSCRIBER_STATUS[$data['status']] : "";
                            }
                        ],
                        [
                            'attribute' => 'start_date',
                            'content' => function ($data) {
                                return date("d M y", strtotime($data['start_date']));
                            }
                        ],
                        [
                            'attribute' => 'end_date',
                            'content' => function ($data) {
                                return date("d M y", strtotime($data['end_date']));
                            }
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="widget-2">
            <div class="card shadow-base overflow-hidden">
                <div class="card-header">
                    <h6 class="card-title">Data usage details</h6>
                </div>

                <?php Pjax::begin(['id' => 'data-usage-list']); ?>

                <?=
                ImsGridView::widget([
                    'dataProvider' => $ds,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'framedipaddress', 'label' => 'IP Address',
                            'content' => function ($model) {
                                return $model->framedipaddress;
                            }
                        ],
                        [
                            'label' => 'Upload',
                            'content' => function ($model) {
                                return $model->upload;
                            }
                        ],
                        [
                            'label' => 'Download',
                            'content' => function ($model) {
                                return $model->download;
                            }
                        ],
                        [
                            'attribute' => 'acctstarttime',
                            'content' => function ($data) {
                                return $data['acctstarttime'];
                            }
                        ],
                        [
                            'label' => "acctstoptime",
                            'content' => function ($data) {
                                return $data['acctstoptime'];
                            }
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
</div>