<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;
use common\component\Utils as U;
use common\models\Location;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string|null $cid
 * @property string $name
 * @property string|null $mobile_no
 * @property string|null $phone_no
 * @property string|null $email
 * @property string|null $gender
 * @property string|null $dob
 * @property int $connection_type
 * @property int $operator_id
 * @property int|null $road_id
 * @property string|null $building_id
 * @property string|null $address
 * @property string|null $billing_address
 * @property string|null $gst_no
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property Operator $operator
 * @property CustomerAccount[] $customerAccounts
 * @property CustomerAccountBouquet[] $CustomerAccountBouquets
 */
class Customer extends \common\models\BaseModel {

    public $create_account;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'customer';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['cid', 'name', 'mobile_no', 'phone_no', 'email', 'gender', 'dob', 'connection_type', 'operator_id', 'road_id', 'building_id', 'address', 'billing_address', 'gst_no'],
            self::SCENARIO_CONSOLE => ['cid', 'name', 'mobile_no', 'phone_no', 'email', 'gender', 'dob', 'connection_type', 'operator_id', 'road_id', 'building_id', 'address', 'billing_address', 'gst_no'],
            self::SCENARIO_UPDATE => ['cid', 'name', 'mobile_no', 'phone_no', 'email', 'gender', 'dob', 'connection_type', 'operator_id', 'road_id', 'building_id', 'address', 'billing_address', 'gst_no'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'connection_type', 'operator_id', 'road_id'], 'required'],
            [['dob', 'added_on', 'updated_on'], 'safe'],
            [['connection_type', 'operator_id', 'road_id', 'added_by', 'updated_by', 'gender', 'building_id'], 'integer'],
            [['cid', 'name', 'mobile_no', 'phone_no', 'email', 'address', 'billing_address', 'gst_no'], 'string', 'max' => 255],
            [['cid'], 'unique'],
            [['operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['operator_id' => 'id']],
        ];
    }

    public function beforeSave($insert) {
        if ($insert) {
            $prefix = CID_PREFIX; //[$this->type];
            $this->cid = empty($this->customer_id) ? $this->generateCode(CID_PREFIX) : $this->cid;
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cid' => 'Cid',
            'name' => 'Name',
            'mobile_no' => 'Mobile No',
            'phone_no' => 'Phone No',
            'email' => 'Email',
            'gender' => 'Gender',
            'dob' => 'Dob',
            'connection_type' => 'Connection Type',
            'operator_id' => 'Operator ID',
            'road_id' => 'Road ID',
            'building_id' => 'Building ID',
            'address' => 'Address',
            'billing_address' => 'Billing Address',
            'gst_no' => 'Gst No',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Operator]].
     *
     * @return \yii\db\ActiveQuery|OperatorQuery
     */
    public function getOperator() {
        return $this->hasOne(Operator::className(), ['id' => 'operator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoad() {
        return $this->hasOne(Location::className(), ['road_id' => 'id'])
                        ->andOnCondition(['type' => C::LOCATION_ROAD]);
    }

    /**
     * Gets query for [[CustomerAccounts]].
     *
     * @return \yii\db\ActiveQuery|CustomerAccountQuery
     */
    public function getAccounts() {
        return $this->hasMany(CustomerAccount::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[CustomerAccountBouquets]].
     *
     * @return \yii\db\ActiveQuery|CustomerAccountBouquetQuery
     */
    public function getAccountPlans() {
        return $this->hasMany(CustomerAccountBouquet::className(), ['customer_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find() {
        return new CustomerQuery(get_called_class());
    }

    public function getGenderName() {
        return !empty(C::LABEL_GENDER[$this->gender]) ? C::LABEL_GENDER[$this->gender] : $this->gender;
    }

    public function getConnectionType() {
        return !empty(C::LABEL_CONNECTION_TYPE[$this->connection_type]) ? C::LABEL_CONNECTION_TYPE[$this->connection_type] : $this->connection_type;
    }

}
