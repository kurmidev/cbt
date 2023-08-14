<?php

namespace common\ebl\payment;

interface IPayment {

    public function requestHandler();

    public function responseHandler(Array $res);
    
    public function sanitaizeResponse(Array $res);
    
    public function reconcilePendingRequest();
}
