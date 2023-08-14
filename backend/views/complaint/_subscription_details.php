<?php

use common\ebl\Constants as C;
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Plan</th>
            <th>Plan Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($account->CustomerAccountBouquets as $s) { ?>
            <tr>
                <td><?= $s->plan->name ?></td>
                <td><?= !empty(C::LABEL_PLAN_TYPE[$s->plan_type]) ? C::LABEL_PLAN_TYPE[$s->plan_type] : $s->plan_type ?></td>
                <td><?= $s->start_date ?></td>
                <td><?= $s->end_date ?></td>
                <td><?= !empty(C::LABEL_SUBSCRIBER_STATUS[$s->status]) ? C::LABEL_SUBSCRIBER_STATUS[$s->status] : $s->status ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>