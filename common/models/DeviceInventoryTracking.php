<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "device_inventory_tracking".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $device_name
 * @property mixed $vendor_name
 * @property mixed $serial_no
 * @property mixed $meta_data
 * @property mixed $purchase_number
 * @property mixed $warranty_date
 * @property mixed $account_id
 * @property mixed $operator_name
 * @property mixed $subscriber_name
 * @property mixed $status
 * @property mixed $challan_number
 * @property mixed $remark
 * @property mixed $activity_done
 * @property mixed $activity_date
 * @property mixed $added_on
 * @property mixed $added_by
 * @property mixed $updated_by
 * @property mixed $updated_on
 */
class DeviceInventoryTracking extends \common\models\BaseMongoModel {

    /**
     * {@inheritdoc}
     */
    public static function collectionName() {
        return 'device_inventory_tracking';
    }

    /**
     * {@inheritdoc}
     */
    public function attributes() {
        return [
            '_id',
            'device_name',
            'vendor_name',
            'serial_no',
            'meta_data',
            'purchase_number',
            'warranty_date',
            'account_id',
            'operator_name',
            'subscriber_name',
            'status',
            'challan_number',
            'remark',
            'activity_done',
            'activity_date',
            'added_on',
            'added_by',
            'updated_by',
            'updated_on',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['device_name', 'vendor_name', 'serial_no', 'purchase_number', 'operator_name', 'status', 'remark', 'activity_done', 'activity_date'], 'required'],
            [['device_name', 'vendor_name', 'serial_no', 'purchase_number', 'operator_name', 'subscriber_name', 'challan_number', 'remark', 'activity_done'], 'string'],
            [['account_id', 'status', 'added_by', 'updated_by'], "integer"],
            [['warranty_date', 'activity_date', 'added_on', 'updated_on'], "date", "format" => "php:Y-m-d"],
            [['device_name', 'vendor_name', 'serial_no', 'meta_data', 'purchase_number', 'warranty_date', 'account_id', 'operator_name', 'subscriber_name', 'status', 'challan_number', 'remark', 'activity_done', 'activity_date', 'added_on', 'added_by', 'updated_by', 'updated_on'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            '_id' => 'ID',
            'device_name' => 'Device Name',
            'vendor_name' => 'Vendor Name',
            'serial_no' => 'Serial No',
            'meta_data' => 'Meta Data',
            'purchase_number' => 'Purchase Number',
            'warranty_date' => 'Warranty Date',
            'account_id' => 'Account ID',
            'operator_name' => 'Operator Name',
            'subscriber_name' => 'Subscriber Name',
            'status' => 'Status',
            'challan_number' => 'Challan Number',
            'remark' => 'Remark',
            'activity_done' => 'Activity Done',
            'activity_date' => 'Activity Date',
            'added_on' => 'Added On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
            'updated_on' => 'Updated On',
        ];
    }

}
