<?php

namespace common\ebl\payment;

use common\component\Utils as U;
use yii\helpers\ArrayHelper;

class PG {

    public $gatewayObj;

    public function __construct($data) {
        $activeGateway = U::activePG();

        if (!empty($activeGateway[$data['gateway']])) {
            $pg = $activeGateway[$data['gateway']];

            $class = $pg['class'];
            $conf = ArrayHelper::merge($data, $pg);
            unset($conf['class'], $conf['id']);
            $this->gatewayObj = new $class($conf);
        }
    }

    public function initiatePayment() {
        $resp = $this->gatewayObj->initiateTransaction();
        if ($resp) {
            return $resp;
        }
        throw new Exception("Invalid configuration. Payment setting not configured properly.");
    }

    public function processPayment($data) {
        $resp = $this->gatewayObj->responseHandler($data);
        if (!empty($resp)) {
            return $this->gatewayObj->processTransaction($resp);
        }
        return false;
    }

}
