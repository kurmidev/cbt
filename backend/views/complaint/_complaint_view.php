<div id="accordion" class="accordion" role="tablist" aria-multiselectable="true">
    <div class="card">
        <div class="card-header" role="tab" id="headingOne">
            <h6 class="mg-b-0">
                <a data-toggle="collapse" data-parent="#accordion" href="#customer_details"
                   aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition">
                    Customer Detail
                </a>
            </h6>
        </div><!-- card-header -->
        <div class="card-header" role="tab" id="headingTwo">
            <h6 class="mg-b-0">
                <a data-toggle="collapse" data-parent="#accordion" href="#account_details"
                   aria-expanded="false" aria-controls="collapseTwo" class="tx-gray-800 transition">
                    Account Detail
                </a>
            </h6>
        </div><!-- card-header -->
        <div class="card-header" role="tab" id="headingThree">
            <h6 class="mg-b-0">
                <a data-toggle="collapse" data-parent="#accordion" href="#plan_details"
                   aria-expanded="false" aria-controls="collapseThree" class="tx-gray-800 transition">
                    Subscription Detail
                </a>
            </h6>
        </div><!-- card-header -->
        <div class="card-header" role="tab" id="headingFour">
            <h6 class="mg-b-0">
                <a data-toggle="collapse" data-parent="#accordion" href="#complaint_details"
                   aria-expanded="false" aria-controls="collapseFour" class="tx-gray-800 transition">
                    Complaint Detail
                </a>
            </h6>
        </div><!-- card-header -->

        <div id="customer_details" class="collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="card-block pd-20">
                <?= $this->render('_customer_details', ['customer' => $customer]) ?>
            </div>
        </div>

        <div id="account_details" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="card-block pd-20">
                <?= $this->render('_account_details', ['account' => $account]) ?>
            </div>
        </div>

        <div id="plan_details" class="collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="card-block pd-20">
                <?= $this->render('_subscription_details', ['account' => $account]) ?>
            </div>
        </div>


        <div id="complaint_details" class="collapse" role="tabpanel" aria-labelledby="headingFour">
            <div class="card-block pd-20">
                <?= $this->render('_complaint_details', ['complaint' => $complaint]) ?>
            </div>
        </div>
    </div><!-- card -->

</div><!-- card -->
<!-- ADD MORE CARD HERE -->
</div><!-- accordion -->