<?php

use yii\helpers\Html;

$type = ($model->operator->type == common\ebl\Constants::OPERATOR_TYPE_LCO) ? 'franchise' :
        (($model->operator->type == common\ebl\Constants::OPERATOR_TYPE_DISTRIBUTOR) ? 'distributor' : 'ro');
?>\
<div>
    <?=
    Html::a("<span class='fa fa-arrow-left'></span>",
            Yii::$app->urlManager->createUrl(['operator/view-' . $type, 'id' => $model->operator_id]),
            ["class" => "h3 text-right pd-10 pull-right mb-10"]
    )
    ?>
</div>
<div class="m-5 text-center d-flex justify-content-center w-auto">
    <div class="row row-printable wd-100v" id="printarea">
        <div class="col-md-12">
            <!-- col-lg-12 start here -->
            <div id="dash_0" style="background-color:#fefefe!important;border:1px solid">
                <!-- Start .panel -->
                <div class="panel-body pd-10 ">
                    <div class="row">
                        <!-- Start .row -->
                        <!-- col-lg-6 end here -->
                        <div class="col-lg-12 pd-10 border border-top-0 border-left-0 border-right-0">
                            <!-- col-lg-6 start here -->
                            <div class="row">
                                <div class="col-lg-5 col-md-2 col-xl-2 col-xs-2 pd-5">
                                    <?= Html::img("data:image/png;base64," . $model->operator->logo, ['width' => 50, 'height' => 50]) ?>
                                </div>
                                <div class="col-lg-8 col-md-8 col-xl-8 col-xs-8 text-left">
                                    <ul class="list-unstyled text-center">
                                        <li><h3><?= $model->operator->billedBy->name ?></h3></li>
                                        <li><h5><?= $model->operator->billedBy->address ?></h5></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row  border border-top-0 border-left-0 border-right-0">
                        <div class="invoice-details mt-2 mb-2 col-lg-8 text-left">
                            <div class="well">
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Order Id#:</strong>  <?= $model->order_id ?> </li>
                                    <li><strong>Receipt#:</strong>  <?= $model->operatorWallet->receipt_no ?> </li>
                                    <li><strong>Receipt Date:</strong> <?= date("d F Y", strtotime($model->added_on)) ?> </li>

                                </ul>
                            </div>
                        </div>
                        <div class=" mt-2 col-lg-4 text-left" >
                            <ul class="list-unstyled">
                                <li><strong>Receipt To</strong></li>
                                <li><strong> Name:</strong><?= $model->operator->name . "(" . $model->operator->code . ")" ?></li>
                                <li><strong>Address :</strong><?= $model->operator->address ?> </li>
                                <li><strong> Mobile No:</strong><?= $model->operator->mobile_no ?></li> 
                            </ul>
                        </div>
                    </div>
                    <div class="row  border border-top-0 border-left-0 border-right-0">
                        <div class="invoice-details mt-2 mb-2 col-lg-8 text-left">
                            <div class="well">
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Received Amount:</strong>  <?= $model->amount ?> </li>
                                    <li><strong>Amount in word:</strong>  <?= Yii::$app->formatter->asSpellout($model->amount); ?> </li>
                                    <li><strong>Payment Mode:</strong> <?= $model->operatorWallet->meta_data["pay_mode"] ?> </li>


                                </ul>
                            </div>
                        </div>
                        <div class=" mt-2 col-lg-4 text-left" >
                            <ul class="list-unstyled">
                                <li><strong> Instrument No:</strong><?= $model->operatorWallet->meta_data['instrument_nos'] ?></li>
                                <li><strong>Instrument Name :</strong><?= $model->operatorWallet->meta_data['instrument_name'] ?> </li>
                            </ul>
                        </div>
                        <!-- col-lg-12 end here -->
                    </div>
                    <div class="row  border border-bottom-0 border-top-0 border-left-0 border-right-0 h-50">
                        <div class="col-lg-12 col-md-12 col-xl-12 col-xs-12 text-center pd-10">
                            <p class="text-center m-b-5 f-w-600 f-s" style="font-size: 10px;height: 30px;">
                                <em>  THIS IS COMPUTER GENERATED DOCUMENT AND DOES NOT REQUIRE SIGNATURE</em>
                            </p>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
            </div>
            <!-- End .panel -->
        </div>
        <!-- col-lg-12 end here -->
    </div>
</div>