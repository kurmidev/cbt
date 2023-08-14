<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_order".
 *
 * @property int $id
 * @property string $purchase_number
 * @property string|null $purchase_date
 * @property string|null $invoice_number
 * @property string|null $invoice_date
 * @property int $vendor_id
 * @property int $device_id
 * @property int|null $quantity
 * @property string|null $warranty_date
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 * @property int|null $upload_id
 *
 * @property DeviceMaster $device
 * @property VendorMaster $vendor
 */
class PurchaseOrder extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'purchase_order';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['purchase_number', 'purchase_date', 'invoice_number', 'invoice_date', 'vendor_id', 'device_id', 'quantity', 'warranty_date', 'upload_id'],
            self::SCENARIO_CONSOLE => ['purchase_number', 'purchase_date', 'invoice_number', 'invoice_date', 'vendor_id', 'device_id', 'quantity', 'warranty_date', 'upload_id'],
            self::SCENARIO_UPDATE => ['purchase_number', 'purchase_date', 'invoice_number', 'invoice_date', 'vendor_id', 'device_id', 'quantity', 'warranty_date', 'upload_id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['purchase_number', 'vendor_id', 'device_id', 'upload_id'], 'required'],
            [['purchase_date', 'invoice_date', 'warranty_date', 'added_on', 'updated_on'], 'safe'],
            [['vendor_id', 'device_id', 'quantity', 'added_by', 'updated_by', 'upload_id'], 'integer'],
            [['purchase_number', 'invoice_number'], 'string', 'max' => 255],
            [['device_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeviceMaster::className(), 'targetAttribute' => ['device_id' => 'id']],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => VendorMaster::className(), 'targetAttribute' => ['vendor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'purchase_number' => 'Purchase Number',
            'purchase_date' => 'Purchase Date',
            'invoice_number' => 'Invoice Number',
            'invoice_date' => 'Invoice Date',
            'vendor_id' => 'Vendor ID',
            'device_id' => 'Device ID',
            'quantity' => 'Quantity',
            'warranty_date' => 'Warranty Date',
            'added_on' => 'Added On',
            'upload_id' => 'Upload Log',
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
     * @return PurchaseOrderQuery the active query used by this AR class.
     */
    public static function find() {
        return new PurchaseOrderQuery(get_called_class());
    }

}
