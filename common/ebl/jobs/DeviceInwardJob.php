<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\ebl\jobs;

use common\models\DeviceInventory;
use common\component\Utils as U;
use common\ebl\Constants as C;

/**
 * Description of DeviceInwardJob
 *
 * @author chandrap
 */
class DeviceInwardJob extends BaseJobs {

    public $device_id;
    public $device;
    public $vendor_id;
    public $vendor_code;
    public $warranty_date;
    public $serial_no;
    public $meta_data;
    public $purchase_number;
    public $purchase_date;
    public $invoice_number;
    public $invoice_date;

    public function scenarios() {
        $fields = ["warranty_date"];
        if (!empty($this->scmdl->model_data["device_id"])) {
            $m = \common\models\DeviceMaster::findOne(['id' => $this->scmdl->model_data['device_id']]);
            if ($m instanceof \common\models\DeviceMaster) {
                $fields = \yii\helpers\ArrayHelper::getColumn($m->device_attributes, "name");
            }
        }
        return [
            DeviceInventory::SCENARIO_CREATE => \yii\helpers\ArrayHelper::merge(['purchase_number', 'purchase_date', 'invoice_number', 'invoice_date', 'device_id', 'vendor_id', 'warranty_date'], $fields),
            DeviceInventory::SCENARIO_MIGRATE => $fields
        ];
    }

    public function rules(): array {
        return [
            [["purchase_number", "invoice_number", "purchase_date", "invoice_date", "device_id", "vendor_id", "serial_no", 'warranty_date'], "required"],
            [["purchase_number", "invoice_number",], "string"],
            [["device_id", "vendor_id"], "integer"],
            [["purchase_date", "invoice_date", "warranty_date"], "date", 'format' => "php:Y-m-d"],
            ["device_id", function () {
                    $m = \common\models\DeviceMaster::findOne(['id' => $this->device_id]);
                    if ($m instanceof \common\models\DeviceMaster) {
                        $this->device = $m;
                    }
                }]
        ];
    }

    public function load($data, $formName = null) {
        foreach ($data as $name => $value) {
            if ($this->hasProperty($name)) {
                $this->$name = $value;
            }
        }
        return true;
    }

    public function _execute($data) {
                $loggedInUser = \common\models\User::loggedInUserName();
print_r($loggedInUser);
exit("sks");
        $this->scenario = DeviceInventory::SCENARIO_CREATE;
        if ($this->load($data, '') && $this->validate()) {
            if ($this->validateMetaData($data, $this->device)) {

                $po_id = $this->setOrGetPurchaseOrder();
                if (!empty($po_id)) {
                    $model = new DeviceInventory(['scenario' => DeviceInventory::SCENARIO_CREATE]);
                    $model->vendor_id = $this->vendor_id;
                    $model->device_id = $this->device_id;
                    $model->warranty_date = $this->warranty_date;
                    $model->operator_id = \common\models\User::getMso();
                    $model->serial_no = $this->serial_no;
                    unset($this->meta_data['serial_no']);
                    $model->meta_data = $this->meta_data;
                    $model->purchase_order_id = $po_id;
                    $model->status = C::INVENTORY_STATUS_NEW;
                    $model->upload_id = $this->scmdl->_id;
                    if ($model->validate() && $model->save()) {
                        \common\models\PurchaseOrder::updateAllCounters(['quantity' => 1], ['id' => $po_id]);
                        $this->insertNewDeviceTracking($model);
                        $this->successCnt++;
                        $this->response[$this->count]['message'] = "Ok";
                        return true;
                    } else {
                        $this->errorCnt++;
                        $this->response[$this->count]["message"] = implode(" ", $model->getErrorSummary(true));
                    }
                }
            }
        } else {
            if (!empty($this->errors)) {
                $this->errorCnt++;
                $this->response[$this->count]["message"] = implode(" ", $this->getErrorSummary(true));
            }
        }
        return false;
    }

    public function validateMetaData($data, \common\models\DeviceMaster $device) {
        $error = [];
        foreach ($device->device_attributes as $attr) {
            if (!empty($data[$attr['name']])) {
                if (U::deviceDataValidation($data[$attr['name']], $attr['length'], $attr['type'])) {
                    $this->meta_data[$attr['name']] = $data[$attr['name']];
                } else {
                    $error[] = $attr['name'] . " value is invalid.";
                }
            } else {
                $error[] = $attr['name'] . " value is required.";
            }
        }

        if (!empty($error)) {
            $this->errorCnt++;
            $this->response[$this->count]["message"] = implode(" ", $error);
            return false;
        }

        return true;
    }

    public function setOrGetPurchaseOrder() {
        $model = \common\models\PurchaseOrder::find()->where(['purchase_number' => $this->purchase_number, 'invoice_number' => $this->invoice_number])->one();
        if (!$model instanceof \common\models\PurchaseOrder) {
            $model = new \common\models\PurchaseOrder(['scenario' => \common\models\PurchaseOrder::SCENARIO_CREATE]);
            $model->purchase_number = $this->purchase_number;
            $model->purchase_date = $this->purchase_date;
            $model->invoice_number = $this->invoice_number;
            $model->invoice_date = $this->invoice_date;
            $model->vendor_id = $this->vendor_id;
            $model->device_id = $this->device_id;
            $model->quantity = 0;
            $model->warranty_date = $this->warranty_date;
            $model->upload_id = $this->scmdl->_id;
            if ($model->validate() && $model->save()) {
                return $model->id;
            } else {
                $this->errorCnt++;
                $this->response[$this->count]["message"] = implode(" ", $model->getErrorSummary(true));
            }
        } else if ($model instanceof \common\models\PurchaseOrder) {
            return $model->id;
        }
        return false;
    }

    public function insertNewDeviceTracking(DeviceInventory $device) {
        $model = new \common\models\DeviceInventoryTracking();
        $model->device_name = $device->device->name;
        $model->vendor_name = $device->vendor->name;
        $model->serial_no = $device->serial_no;
        $model->meta_data = $device->meta_data;
        $model->purchase_number = $device->purchaseOrder->purchase_number;
        $model->warranty_date = $device->warranty_date;
        $model->account_id = $device->account_id;
        $model->operator_name = $device->operator->name;
        $model->subscriber_name = !empty($model->account) ? $model->account->subscriber->name : "";
        $model->status = $device->status;
        $model->challan_number = "";
        $loggedInUser = \common\models\User::loggedInUserName();
        $model->remark = "{$device->serial_no} inwarded by {$loggedInUser} on {$device->added_on} with purchase order {$device->purchaseOrder->purchase_number}";
        $model->activity_done = C::ACTIVITY_DEVICE_INWARDED;
        $model->activity_date = date("Y-m-d");
        if ($model->validate() && $model->save()) {
            
        }else{
            print_r($model->errors);
            exit;
        }
    }

}
