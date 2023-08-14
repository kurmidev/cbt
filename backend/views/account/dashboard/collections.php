<div class="card">
    <div class="card-header">
        <h6 class="card-title">Payment</h6>
    </div>
    <div class="card-body">
        <div>
            <span class="tx-11">Last Payment Date</span>
            <h6 class="tx-inverse tx-11"><?= !empty($account->lastPayment) ? $account->lastPayment->added_on : 'N/A' ?></h6>
        </div>
        <div>
            <span class="tx-11">Last Payment Amount</span>
            <h6 class="tx-inverse tx-11"><?= !empty($account->lastPayment) ? $account->lastPayment->amount : 'N/A' ?></h6>
        </div>
    </div>
    <div class="card-footer">
        <div>
            <span class="tx-11">Debit</span>
            <h6 class="tx-inverse tx-11"><?= !empty($account->drAmount[0]) ? $account->drAmount[0]['total'] : 0 ?></h6>
        </div>
        <div>
            <span class="tx-11">Credit</span>
            <h6 class="tx-inverse tx-11"><?= !empty($account->crAmount[0]) ? $account->crAmount[0]['total'] : 0 ?></h6>
        </div>
        <div>
            <span class="tx-11">Balance</span>
            <h6 class="tx-inverse tx-11"><?= $account->balance ?></h6>
        </div>
    </div>
</div>