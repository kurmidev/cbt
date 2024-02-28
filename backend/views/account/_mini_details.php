<?php

use yii\helpers\Html;;
use common\ebl\Constants as C;
?>

<div class="card-body">
    <div class="row">
        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
            <div class="card">
                <div class="card-header">Customer Details</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-name">
                                <label class="control-label" for="accountform-name">Name</label>
                                <span class="form-control"><?= $account->customer->name ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-name">
                                <label class="control-label" for="accountform-cid">CID</label>
                                <span class="form-control"><?= $account->customer->cid ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-username">
                                <label class="control-label" for="accountform-username">Username</label>
                                <span class="form-control"><?= $account->username ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-name">
                                <label class="control-label" for="accountform-contact">Mobile/Phone</label>
                                <span class="form-control"><?= $account->customer->mobile_no . "/" . $account->customer->phone_no ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-name">
                                <label class="control-label" for="accountform-franchise">Franchise</label>
                                <span class="form-control"><?= $account->operator->name ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-name">
                                <label class="control-label" for="accountform-address">Address</label>
                                <span class="form-control"><?= $account->customer->address ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-building">
                                <label class="control-label" for="accountform-building">Building</label>
                                <span class="form-control"><?= $account->building->name ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-road">
                                <label class="control-label" for="accountform-road">Road</label>
                                <span class="form-control"><?= $account->road->name ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-road">
                                <label class="control-label" for="accountform-balance">Wallet Balance</label>
                                <span class="form-control"><?= $account->balance ?></span>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
            <div class="card">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-name">
                                <label class="control-label" for="accountform-start_date">Start Date</label>
                                <span class="form-control"><?= $account->start_date ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-name">
                                <label class="control-label" for="accountform-end_date">End Date</label>
                                <span class="form-control"><?= $account->end_date ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-name">
                                <label class="control-label" for="accountform-mac_address">MAC Address</label>
                                <span class="form-control"><?= $account->mac_address ?>&nbsp;</span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-6 col-lg-6 col-xl-6">
                            <div class="form-group field-accountform-name">
                                <label class="control-label" for="accountform-ip_address">IP Address</label>
                                <span class="form-control"><?= $account->ipAddress ?>&nbsp;</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if (!empty($account->activePlans)) { ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Plan Name</th><th>Type</th><th>Start Date</th><th>End Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($account->activePlans as $plans) { ?>

                                        <tr>
                                            <td><?= $plans->plan->name ?></td>
                                            <td><?= $plans->planTypeLabel ?></td>
                                            <td><?= $plans->start_date ?></td>
                                            <td><?= $plans->end_date ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>