<?php
$this->title = "Invoice Details";
$this->params['breadcrumbs'][] = $this->title;
$sub_amount = $model->plans_amount + $model->credit_amount + $model->debit_amount;
$sub_tax = $model->plans_tax + $model->credit_tax + $model->debit_tax;
$total = $model->plans_amount + $model->credit_amount + $model->debit_amount + $model->plans_tax + $model->credit_tax + $model->debit_tax + $model->credit_nt_amount + $model->debit_nt_amount + $model->payment_amount;
?>

<div class="m-5 text-center d-flex justify-content-center">
    <div class="row row-printable" id="printarea">
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
                            <div class="invoice-from">
                                <ul class="list-unstyled text-center">
                                    <li><h3><?= $billby->name ?></h3></li>
                                    <li><h5><?= $billby->address ?></h5></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="invoice-details mt-5 col-lg-6 text-left">
                            <div class="well">
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Invoice Date:</strong> <?= date("F Y", strtotime($billmonth)) ?></li>
                                    <li><strong>Bill Date:</strong> 
                                        <?= date("d-m-y", strtotime($billStartDate)) ?> to 
                                        <?= date("d-m-y", strtotime($billEndDate)) ?> 
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class=" mt-2 col-lg-6" style="text-align: right">
                            <ul class="list-unstyled">
                                <li><strong>Invoiced To</strong></li>
                                <li><?= $model->customer->name ?>(<?= $model->customer->cid ?>)</li>
                                <li><b>Username :</b><?= $model->account->username ?></li>
                                <li><?= implode(",<br>", explode(",", $model->customer->address)) ?></li>
                            </ul>
                        </div>

                        <div class="col-lg-12">
                            <div class="invoice-items">
                                <div class="table-responsive" style="overflow: hidden; outline: none;" tabindex="0">
                                    <table class="table table-bordered">
                                        <thead>
                                        <th>Current Charges (A)</th>
                                        <th>Credit WOT(B)</th>
                                        <th>Debit WOT (C)</th>
                                        <th>Payment(D)</th>
                                        <th>Total<br>(A-B+C+D)</th>
                                        </thead>
                                        <tbody> 
                                        <td><?= $sub_amount + $sub_tax ?></td>
                                        <td><?= $model->credit_nt_amount ?></td>
                                        <td><?= $model->debit_nt_amount ?></td>
                                        <td><?= $model->payment_amount ?></td>
                                        <td><?= $total ?></td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- col-lg-6 end here -->
                        <div class="col-lg-12">
                            <!-- col-lg-12 start here -->

                            <div class="invoice-items">
                                <div class="table-responsive" style="overflow: hidden; outline: none;" tabindex="0">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center"> <h5 >Summary of Charges</h5></th>
                                            </tr>
                                            <tr>
                                                <th class="per70 text-center">Item</th>
                                                <th class="per25 text-center">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Subscription Charges</td>
                                                <td class="text-center"><?= abs($model->plans_amount) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Debit Charges</td>
                                                <td class="text-center"><?= abs($model->debit_amount) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Credit Charges</td>
                                                <td class="text-center"><?= abs($model->credit_amount) ?></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-right">Sub Amount:</th>
                                                <th class="text-center"><?= abs($sub_amount) ?></th>
                                            </tr>
                                            <tr>
                                                <th class="text-right">Sub Tax:</th>
                                                <th class="text-center"><?= abs($sub_tax) ?></th>
                                            </tr>
                                            <tr>
                                                <th class="text-right">Total Current Charges:</th>
                                                <th class="text-center"><?= abs($sub_tax + $sub_amount) ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="invoice-footer mt25">

                            </div>
                        </div>
                        <!-- col-lg-12 end here -->
                    </div>
                    <!-- End .row -->
                </div>
            </div>
            <!-- End .panel -->
        </div>
        <!-- col-lg-12 end here -->
    </div>
</div>