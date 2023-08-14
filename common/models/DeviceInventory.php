<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "device_inventory".
 *
 * @property int $id
 * @property int $vendor_id
 * @property int $device_id
 * @property string|null $warranty_date
 * @property int $operator_id
 * @property int|null $account_id
 * @property string $serial_no
 * @property string|null $meta_data
 * @property int|null $purchase_order_id
 * @property string|null $operator_scheme
 * @property string|null $customer_scheme
 * @property int|null $locked_at
 * @property string|null $locked_token
 * @property int $status
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 * @property int|null $upload_id
 *
 * @property DeviceMaster $device
 * @property Operator $operator
 * @property VendorMaster $vendor
 */
class DeviceInventory extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'device_inventory';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['vendor_id', 'device_id', 'warranty_date', 'operator_id', 'account_id', 'serial_no', 'meta_data', 'purchase_order_id', 'operator_scheme', 'customer_scheme', 'locked_at', 'locked_token', 'status', 'upload_id'],
            self::SCENARIO_CONSOLE => ['vendor_id', 'device_id', 'warranty_date', 'operator_id', 'account_id', 'serial_no', 'meta_data', 'purchase_order_id', 'operator_scheme', 'customer_scheme', 'locked_at', 'locked_token', 'status', 'upload_id'],
            self::SCENARIO_UPDATE => ['vendor_id', 'device_id', 'warranty_date', 'operator_id', 'account_id', 'serial_no', 'meta_data', 'purchase_order_id', 'operator_scheme', 'customer_scheme', 'locked_at', 'locked_token', 'status', 'upload_id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['vendor_id', 'device_id', 'operator_id', 'serial_no', 'status', 'upload_id'], 'required'],
            [['vendor_id', 'device_id', 'operator_id', 'account_id', 'purchase_order_id', 'locked_at', 'status', 'added_by', 'updated_by', 'upload_id'], 'integer'],
            [['warranty_date', 'meta_data', 'operator_scheme', 'customer_scheme', 'added_on', 'updated_on'], 'safe'],
            [['serial_no', 'locked_token'], 'string', 'max' => 255],
            [['serial_no'], 'unique'],
            [['device_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeviceMaster::className(), 'targetAttribute' => ['device_id' => 'id']],
            [['operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['operator_id' => 'id']],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => VendorMaster::className(), 'targetAttribute' => ['vendor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'vendor_id' => 'Vendor ID',
            'device_id' => 'Device ID',
            'warranty_date' => 'Warranty Date',
            'operator_id' => 'Operator ID',
            'account_id' => 'Account ID',
            'serial_no' => 'Serial No',
            'meta_data' => 'Meta Data',
            'purchase_order_id' => 'Purchase Order ID',
            'operator_scheme' => 'Operator Scheme',
            'customer_scheme' => 'Customer Scheme',
            'locked_at' => 'Locked At',
            'locked_token' => 'Locked Token',
            'status' => 'Status',
            'upload_id' => 'Upload Id',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Device]].
     *
     * @return \yii\db\ActiveQuery|DeviceMasterQuery
     */
    public function getDevice() {
        return $this->hasOne(DeviceMaster::className(), ['id' => 'device_id']);
    }

    /**
     * Gets query for [[Operator]].
     *
     * @return \yii\db\ActiveQuery|OperatorQuery
     */
    public function getOperator() {
        return $this->hasOne(Operator::className(), ['id' => 'operator_id']);
    }

    public function getPurchaseOrder() {
        return $this->hasOne(PurchaseOrder::class, ['id' => 'purchase_order_id']);
    }

    /**
     * Gets query for [[Vendor]].
     *
     * @return \yii\db\ActiveQuery|VendorMasterQuery
     */
    public function getVendor() {
        return $this->hasOne(VendorMaster::className(), ['id' => 'vendor_id']);
    }

    /**
     * Gets query for [[Vendor]].
     *
     * @return \yii\db\ActiveQuery|VendorMasterQuery
     */
    public function getScheduleUpload() {
        return $this->hasOne(ScheduleJobLogs::className(), ['id' => 'upload_id']);
    }

    /**
     * {@inheritdoc}
     * @return DeviceInventoryQuery the active query used by this AR class.
     */
    public static function find() {
        return new DeviceInventoryQuery(get_called_class());
    }

    public function afterSave($insert, $changedAttributes) {
        return parent::afterSave($insert, $changedAttributes);
    }

    public function getAccount() {
        return $this->hasOne(CustomerAccount::class, ['id' => 'account_id']);
    }

}
