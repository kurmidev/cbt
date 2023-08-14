<?php

Use common\ebl\Constants as C;

$plan_name = !empty($account->activePlans) ? implode(", ", yii\helpers\ArrayHelper::getColumn($account->activePlans, 'plan.name')) : "--";
?>

<ul class="list-group list-group-flush">
    <li class="list-group-item">Username: <b><?= $account->username ?></b></li>
    <li class="list-group-item">Start Date: <b><?= $account->start_date ?></b></li>
    <li class="list-group-item">End Date: <b><?= $account->end_date ?></b></li>
    <li class="list-group-item">Account Type: <b><?= !empty(C::LABEL_ACCOUNT_TYPE[$account->account_types]) ? C::LABEL_ACCOUNT_TYPE[$account->account_types] : $account->account_types ?></b></li>
    <li class="list-group-item">MAC Address: <b><?= $account->mac_address ?></b></li>
    <li class="list-group-item">Auto Renew: <b><?= $account->is_auto_renew ? "Yes" : "No" ?></b></li>
    <li class="list-group-item">Active Plan: <b><?= $plan_name ?></b></li>
    <li class="list-group-item">Balance: <b><?= $account->balance ?> <span class="fa fa-inr"></span></b></li>
</ul>