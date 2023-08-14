<?php

namespace common\ebl\ott;

interface IOtt {

    /**
     * Fetch OTT Plan from OTT provider server
     */
    public function fetchOtt();

    /**
     * Subscribe OTT plan to customer
     */
    public function subscribe();

    /**
     * Reconcile  OTT subscriber with below
     */
    public function reconcile();
}
