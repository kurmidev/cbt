<?php

namespace common\forms;

use common\models\DeviceMaster;

class InwardDeviceForm extends MigrationJobs {

    public $device_id;
    public $purchase_number;
    public $purchase_date;
    public $invoice_number;
    public $invoice_date;
    public $vendor_id;
    public $type;
    public $model;
    public $file;
    public $filePath;
    public $model_data;
    public $id;

    public function scenarios() {
        return [
            DeviceMaster::SCENARIO_CREATE => ["type", "model", "file", "filePath", 'id', 'model_data', 'purchase_number', 'purchase_date', 'invoice_number', 'invoice_date', 'vendor_id', 'device_id'],
            DeviceMaster::SCENARIO_UPDATE => ["type", "model", "file", "filePath", 'id', 'model_data', 'purchase_number', 'purchase_date', 'invoice_number', 'invoice_date', 'vendor_id', 'device_id'],
        ];
    }

    public function rules() {
        return [
            [["type", "model", "type", 'purchase_number', 'purchase_date', 'invoice_number', 'invoice_date', 'device_id'], 'required'],
            [["type", "id", "device_id"], "integer"],
            [["model", "invoice_number", "purchase_number"], "string"],
            [['file'], 'file', 'extensions' => 'csv'],
            [["file", 'filePath', 'model_data'], "safe"],
            ['device_id', function () {
                    $m = DeviceMaster::findOne(['id' => $this->device_id]);
                    if ($m instanceof DeviceMaster) {
                        $this->vendor_id = $m->vendor_id;
                    } else {
                        $this->addError("device_id", "Invalid device selected.");
                    }
                }],
            [['purchase_number', 'invoice_number'], 'unique', "targetClass" => \common\models\PurchaseOrder::class, 'targetAttribute' => ["purchase_number", "invoice_number"]]
        ];
    }

    public function getDwnFields() {
        $devices = DeviceMaster::find()->active()->all();
        $list = [];
        foreach ($devices as $device) {
            if (!empty($device->device_attributes)) {
                $list[$device->id] = [
                    "cols" => \yii\helpers\ArrayHelper::merge(\yii\helpers\ArrayHelper::getColumn($device->device_attributes, "name"), ['warranty_date']),
                    "file" => str_replace(" ", "_", $device->name . "_inward")
                ];
            }
        }
        return $list;
    }

    public function afterValidate() {

        $this->model_data = [
            "purchase_number" => $this->purchase_number,
            "purchase_date" => $this->purchase_date,
            "invoice_number" => $this->invoice_number,
            "invoice_date" => $this->invoice_date,
            "vendor_id" => $this->vendor_id,
            "device_id" => $this->device_id
        ];
        return parent::afterValidate();
    }

}
