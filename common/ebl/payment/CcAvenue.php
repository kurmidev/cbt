<?php

namespace common\ebl\payment;

class CcAvenue extends Payments implements \common\ebl\payment\IPayment {

    use Crypto;

    const SUCCESS = ["success", "shipped", "successful"];
    const FAILURE = ["aborted", "failure", "invalid", "unsuccessful", "awaited", "initiated", "fraud", "timeout"];

    public function __construct($config = []) {
        parent::__construct($config);
    }

    public function generateUserData() {
        $data = parent::generateUserData();
        return [
            "billing_name" => $data['name'],
            "billing_address" => $data['address'],
            "billing_tel" => $data['mobileno'],
            "billing_email" => $data['email'],
            "delivery_name" => $data['username'],
            "delivery_address" => $data['address'],
            "delivery_tel" => $data['mobileno'],
            "merchant_param1" => $data['code'],
            "customer_identifier" => $data['username']
        ];
    }

    public function requestHandler() {
        $res = [
            'currency' => 'INR',
            'merchant_id' => $this->meta_data['merchant_id'],
            $this->meta_data['merchant_id'] . 'tid' => time(),
            'language' => 'EN',
            'redirect_url' => $this->returnUrl,
            'cancel_url' => $this->returnUrl,
            "amount" => $this->amount,
            "currency" => 'INR',
            "order_id" => $this->orderId,
            "merchant_param2" => $this->orderId,
            "integration_type" => "iframe_normal"
        ];
        $fd = \yii\helpers\ArrayHelper::merge($res, $this->generateUserData());
        $hash = $this->generateHash($fd);
        $fd['CHECKSUMHASH'] = $hash;
        return [
            "checkout_type" => "iframe",
            //'form_data' => ['encRequest' => $hash, 'access_code' => $this->meta_data['access_code']],
            'form_url' => "{$this->gatewayUrl}/transaction/transaction.do?command=initiateTransaction&encRequest=$hash&access_code=" . $this->meta_data['access_code'],
            'request' => $fd
        ];
    }

    private function generateHash($data) {
        return $this->getChecksumFromArray($data, $this->meta_data['working_key']);
    }

    private function getChecksumFromArray($data, $salt) {
        foreach ($data as $key => $value) {
            $merchant_data [] = $key . '=' . urlencode($value);
        }
        $merchant = implode("&", $merchant_data);
        return $this->encrypt($merchant, $salt);
    }

    public function responseHandler($data) {
        if (\yii\helpers\ArrayHelper::keyExists('encResp', $data)) {
            $data = $this->sanitaizeResponse($data['encResp']);
            return [
                "order_id" => $data['order_id'],
                "order_status" => in_array(strtolower($data['order_status']), self::SUCCESS) ? 1 :
                (in_array(strtolower($data['order_status']), self::FAILURE) ? 0 : -1 ),
                "amount" => $data['amount'],
                "resp" => $data
            ];
        }
    }

    public function sanitaizeResponse($param) {
        $decryptData = $this->decrypt($param, $this->meta_data['working_key']);
        $decryptValues = explode('&', $decryptData);
        $dataSize = sizeof($decryptValues);
        $respData = [];
        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            $respData[$information[0]] = $information[1];
        }
        return $respData;
    }

    public function reconcilePendingRequest() {
        ;
    }

}
