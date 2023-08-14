<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "device_requisition".
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property int $status
 * @property int $state
 * @property string|null $approval_meta_data
 * @property string|null $meta_data
 * @property int|null $approved_quantity
 * @property int|null $purchased_quantity
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property Operator $company
 * @property DeviceRequisitionItems[] $deviceRequisitionItems
 */
class DeviceRequisition extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'device_requisition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['company_id', 'name', 'code', 'description', 'status'], 'required'],
            [['company_id', 'status', 'state', 'approved_quantity', 'purchased_quantity', 'added_by', 'updated_by'], 'integer'],
            [['approval_meta_data', 'meta_data', 'added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'description'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
            'status' => 'Status',
            'state' => 'State',
            'approval_meta_data' => 'Approval Meta Data',
            'meta_data' => 'Meta Data',
            'approved_quantity' => 'Approved Quantity',
            'purchased_quantity' => 'Purchased Quantity',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery|OperatorQuery
     */
    public function getCompany() {
        return $this->hasOne(Operator::className(), ['id' => 'company_id']);
    }

    /**
     * Gets query for [[DeviceRequisitionItems]].
     *
     * @return \yii\db\ActiveQuery|DeviceRequisitionItemsQuery
     */
    public function getDeviceRequisitionItems() {
        return $this->hasMany(DeviceRequisitionItems::className(), ['requisition_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DeviceRequisitionQuery the active query used by this AR class.
     */
    public static function find() {
        return new DeviceRequisitionQuery(get_called_class());
    }

}
