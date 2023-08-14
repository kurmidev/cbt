<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vendor_master".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $point_of_contact
 * @property string $mobile_no
 * @property string|null $email
 * @property string|null $address
 * @property string|null $pan_no
 * @property string|null $gst_no
 * @property int|null $status
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property DeviceInventory[] $deviceInventories
 * @property DeviceMaster[] $deviceMasters
 * @property PurchaseOrder[] $purchaseOrders
 */
class VendorMaster extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'vendor_master';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'],
            self::SCENARIO_CREATE => ["name", "code", "point_of_contact", "mobile_no", "status", "email", "address", "pan_no", "gst_no"],
            self::SCENARIO_UPDATE => ["name", "code", "point_of_contact", "mobile_no", "status", "email", "address", "pan_no", "gst_no"],
            self::SCENARIO_CONSOLE > ["name", "code", "point_of_contact", "mobile_no", "status", "email", "address", "pan_no", "gst_no"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'point_of_contact', 'mobile_no'], 'required'],
            [['status', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on', "code"], 'safe'],
            [['name', 'code', 'point_of_contact', 'mobile_no', 'email', 'address', 'pan_no', 'gst_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'point_of_contact' => 'Contact Person',
            'mobile_no' => 'Mobile No',
            'email' => 'Email',
            'address' => 'Address',
            'pan_no' => 'PAN No',
            'gst_no' => 'GST No',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {

        if ($this->scenario == self::SCENARIO_CREATE) {
            $this->code = empty($this->code) ? $this->generateCode(\common\ebl\Constants::PREFIX_VENDOR) : $this->code;
        }

        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[DeviceInventories]].
     *
     * @return \yii\db\ActiveQuery|DeviceInventoryQuery
     */
    public function getDeviceInventories() {
        return $this->hasMany(DeviceInventory::className(), ['vendor_id' => 'id']);
    }

    /**
     * Gets query for [[DeviceMasters]].
     *
     * @return \yii\db\ActiveQuery|DeviceMasterQuery
     */
    public function getDeviceMasters() {
        return $this->hasMany(DeviceMaster::className(), ['vendor_id' => 'id']);
    }

    /**
     * Gets query for [[PurchaseOrders]].
     *
     * @return \yii\db\ActiveQuery|PurchaseOrderQuery
     */
    public function getPurchaseOrders() {
        return $this->hasMany(PurchaseOrder::className(), ['vendor_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return VendorMasterQuery the active query used by this AR class.
     */
    public static function find() {
        return new VendorMasterQuery(get_called_class());
    }

}
