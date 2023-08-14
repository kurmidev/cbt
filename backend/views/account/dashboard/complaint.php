<?php

use common\ebl\Constants as C;

$complaint = common\models\Complaint::find()->where(['account_id' => $account->id])->orderBy(['id' => SORT_DESC])->one();
?>

<div class="card">
    <div class="card-header">
        <h6 class="card-title">Complaint Status</h6>
    </div>
    <div class="card-body">
        <div>
            <span class="tx-11">Last Complaint</span>
            <h6 class="tx-inverse tx-11"><?= !empty($complaint) ? $complaint->ticketno : "N/A" ?></h6>
        </div>
        <div>
            <span class="tx-11">Status</span>
            <h6 class="tx-inverse tx-11"><?= !empty($complaint) ? C::COMPLAINT_SATGES[$complaint->status] : "N/A" ?></h6>
        </div>
        <div>
            <span class="tx-11">Date</span>
            <h6 class="tx-inverse tx-11"><?= !empty($complaint) ? $complaint->added_on : "N/A" ?></h6>
        </div>
    </div>
    <div class="card-footer">
        <div>
            <span class="tx-11">Pending</span>
            <h6 class="tx-danger tx-11"><?= count($account->openComplaint) ?></h6>
        </div>
        <div>
            <span class="tx-11">Closed</span>
            <h6 class="tx-success tx-11"><?= count($account->closedComplaint) ?></h6>
        </div>
        <div>
            <span class="tx-11">Total</span>
            <h6 class="tx-inverse tx-11"><?= count($account->openComplaint) + count($account->closedComplaint) ?></h6>
        </div>
    </div>
</div>