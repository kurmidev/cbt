<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "device_master".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $vendor_id
 * @property string|null $description
 * @property int $status
 * @property float|null $amount
 * @property float|null $tax
 * @property int $units
 * @property string|null $device_attributes
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property DeviceInventory[] $deviceInventories
 * @property VendorMaster $vendor
 * @property PurchaseOrder[] $purchaseOrders
 */
class DeviceMaster extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'device_master';
    }

    public function scenarios() {
        return [
            self::SCENARIO_CREATE => ['id', 'name', 'code', 'vendor_id', 'description', 'status', 'amount', 'tax', 'units', 'device_attributes'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'code', 'vendor_id', 'description', 'status', 'amount', 'tax', 'units', 'device_attributes'],
            self::SCENARIO_UPDATE => ['id', 'name', 'code', 'vendor_id', 'description', 'status', 'amount', 'tax', 'units', 'device_attributes'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        $dynamic_validate = (new \yii\base\DynamicModel(['name', 'type', 'length']))
                ->addRule(['name', 'type', 'length'], 'required')
                ->addRule(["type", "length"], "integer")
                ->addRule(['name'], "string");

        return [
            [['name', 'vendor_id', 'status', 'units', 'device_attributes'], 'required'],
            [['vendor_id', 'status', 'units', 'added_by', 'updated_by'], 'integer'],
            [['amount', 'tax'], 'number'],
            [['added_on', 'updated_on', 'code'], 'safe'],
            [['name', 'code', 'description'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => VendorMaster::className(), 'targetAttribute' => ['vendor_id' => 'id']],
            [['device_attributes'], 'ValidateMulti', 'params' => ['isMulti' => TRUE, 'ValidationModel' => $dynamic_validate, 'allowEmpty' => FALSE]],
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
            'vendor_id' => 'Vendor ID',
            'description' => 'Description',
            'status' => 'Status',
            'amount' => 'Amount',
            'tax' => 'Tax',
            'units' => 'Units',
            'device_attributes' => 'Device Attributes',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[DeviceInventories]].
     *
     * @return \yii\db\ActiveQuery|DeviceInventoryQuery
     */
    public function getDeviceInventories() {
        return $this->hasMany(DeviceInventory::className(), ['device_id' => 'id']);
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
     * Gets query for [[PurchaseOrders]].
     *
     * @return \yii\db\ActiveQuery|PurchaseOrderQuery
     */
    public function getPurchaseOrders() {
        return $this->hasMany(PurchaseOrder::className(), ['device_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DeviceMasterQuery the active query used by this AR class.
     */
    public static function find() {
        return new DeviceMasterQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if ($this->scenario == self::SCENARIO_CREATE) {
            $this->code = empty($this->code) ? $this->generateCode(\common\ebl\Constants::PREFIX_DEVICE) : $this->code;
        }

        return parent::beforeSave($insert);
    }

}
