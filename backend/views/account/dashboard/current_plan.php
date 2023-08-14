<div class="card">
    <div class="card-header">
        <h6 class="card-title">Current Plans</h6>
    </div>
    <div class="card-footer">
        <?php if (!empty($account->activeBase)) { ?>
            <?php foreach ($account->activeBase as $pl) { ?>
                <div>
                    <h6 class="tx-11"><?= !empty($pl->plan) ? $pl->plan->name : "" ?></h6>
                </div>
                <div>
                    <h6 class="tx-11"><?= date("d M y", strtotime($pl->start_date)) ?></h6>
                </div>
                <div>
                    <h6 class="tx-11"><?= date("d M y", strtotime($pl->end_date)) ?></h6>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>