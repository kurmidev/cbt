<?php

namespace common\ebl\ott;

use common\component\Utils as U;

class GeniusOtt implements IOtt {

    public $config;
    public $header = [];

    public function __construct(Array $c) {
        $this->config = $c;
        $this->header = [
            'Content-Type: application/json',
            "Authorization: Basic {$this->config['api_key']}"
        ];
    }

    public function fetchOtt() {
        $days = U::planDays();
        foreach ($days as $d) {
            $url = $this->createUrl("GFetchCurrentPlans", "?vendorCode={$this->config['vendor_code']}&Validity=$d");
            $response = U::curl($url, $this->header, "", "post");
        }
    }

    public function reconcile() {
        
    }

    public function subscribe() {
        
    }

}
