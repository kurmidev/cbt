<?php

Use common\ebl\Constants as C;
?>
<div class="alert alert-<?= $complaint->stages == C::COMPLAINT_PENDING ? "danger" : "success" ?>" role="alert">
    <h5>Ticket #<?= $complaint->ticketno ?></h5>
</div>
<ul class="list-group list-group-flush">
    <li class="list-group-item">Query: <b><?= $complaint->opening ?></b></li>
    <li class="list-group-item">Follow-up Date: <b><?= $complaint->nextfollowup ?></b></li>
    <li class="list-group-item">Assigned To: <b><?= !empty($complaint->currentlyAssignedUser) ? $complaint->currentlyAssignedUser->name : "" ?></b></li>
    <?php if ($complaint->stages == C::COMPLAINT_CLOSED) { ?>
        <li class="list-group-item">Start Date: <b><?= $complaint->opening_date ?></b></li>
        <li class="list-group-item">End Date: <b><?= $complaint->closing_date ?></b></li>
        <li class="list-group-item">Closing Remark: <b><?= $complaint->closing ?></b></li>
    <?php } ?>
    <li class="list-group-item">
        <h6><b>Complaint Reply Details</b></h6>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Reply</th>
                    <th>Reply Date</th>
                    <th>Replied By</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complaint->complaintDetails as $c) { ?>
                    <tr>
                        <td><?= $c->comments ?></td>
                        <td><?= $c->added_on ?></td>
                        <td><?= $c->addedByName ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </li>
</ul>