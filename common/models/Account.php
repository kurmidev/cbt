<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;
use common\component\Utils as U;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property string $customer_id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $mobile_no
 * @property string $phone_no
 * @property string $email
 * @property int $gender
 * @property string $dob
 * @property int $connection_type
 * @property int $operator_id
 * @property int $road_id
 * @property int $building_id
 * @property int $nas_id
 * @property array $mac_address
 * @property string $static_ip
 * @property array $history
 * @property string $activation_date
 * @property string $deactivation_date
 * @property array $address
 * @property array $bill_address
 * @property int $is_auto_renew
 * @property array $meta_data
 * @property string $other_id
 * @property int $status
 * @property string $added_on
 * @property string $updated_on
 * @property int $added_by
 * @property int $updated_by
 *
 * @property Nas $nas
 * @property Operator $operator
 * @property AccountPlans[] $accountPlans
 */
class Account extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'account';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['customer_id', 'name', 'username', 'password', 'mobile_no', 'phone_no', 'email', 'gender', 'dob', 'connection_type', 'operator_id', 'road_id', 'building_id', 'nas_id', 'mac_address', 'static_ip', 'activation_date', 'deactivation_date', 'address', 'bill_address', 'is_auto_renew', 'meta_data', 'other_id', 'status'],
            self::SCENARIO_CONSOLE => ['id', 'customer_id', 'name', 'username', 'password', 'mobile_no', 'phone_no', 'email', 'gender', 'dob', 'connection_type', 'operator_id', 'road_id', 'building_id', 'nas_id', 'mac_address', 'static_ip', 'activation_date', 'deactivation_dateaddress', 'bill_address', 'is_auto_renew', 'meta_data', 'other_id', 'status'],
            self::SCENARIO_UPDATE => ['id', 'name', 'password', 'mobile_no', 'phone_no', 'email', 'gender', 'dob', 'connection_type', 'nas_id', 'mac_address', 'bill_address', 'is_auto_renew', 'meta_data', 'other_id', 'status'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'username', 'password', 'connection_type', 'operator_id', 'road_id', 'building_id', 'nas_id', 'activation_date', 'deactivation_date', 'status'], 'required'],
            [['gender', 'connection_type', 'operator_id', 'road_id', 'building_id', 'nas_id', 'is_auto_renew', 'status', 'added_by', 'updated_by'], 'integer'],
            [['customer_id', 'dob', 'mac_address', 'history', 'address', 'bill_address', 'meta_data', 'added_on', 'updated_on'], 'safe'],
            [['customer_id', 'name', 'username', 'password', 'mobile_no', 'phone_no', 'email', 'static_ip', 'other_id'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['customer_id'], 'unique'],
            [['nas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nas::className(), 'targetAttribute' => ['nas_id' => 'id']],
            [['operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['operator_id' => 'id']],
        ];
    }

    public function beforeSave($insert) {
        $prefix = CID_PREFIX; //[$this->type];
        $this->customer_id = empty($this->customer_id) ? $this->generateCode(CID_PREFIX) : $this->customer_id;

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'name' => 'Name',
            'username' => 'Username',
            'password' => 'Password',
            'mobile_no' => 'Mobile No',
            'phone_no' => 'Phone No',
            'email' => 'Email',
            'gender' => 'Gender',
            'dob' => 'DOB',
            'connection_type' => 'Connection Type',
            'operator_id' => 'Franchise',
            'road_id' => 'Road',
            'building_id' => 'Building',
            'nas_id' => 'Nas',
            'mac_address' => 'Mac Address',
            'static_ip' => 'Static IP',
            'history' => 'History',
            'activation_date' => 'Start Date',
            'deactivation_date' => 'End Date',
            'address' => 'Address',
            'bill_address' => 'Bill Address',
            'is_auto_renew' => 'Is Auto Renew',
            'meta_data' => 'Meta Data',
            'other_id' => 'Other',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNas() {
        return $this->hasOne(Nas::className(), ['id' => 'nas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperator() {
        return $this->hasOne(Operator::className(), ['id' => 'operator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountPlans() {
        return $this->hasMany(AccountPlans::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoad() {
        return $this->hasOne(Location::className(), ['road_id' => 'id'])
                        ->andOnCondition(['type' => C::LOCATION_ROAD]);
    }

    /**
     * {@inheritdoc}
     * @return AccountQuery the active query used by this AR class.
     */
    public static function find() {
        return new AccountQuery(get_called_class());
    }

    public function addPlans(Array $d) {
        $model = new AccountPlans(['scenario' => AccountPlans::SCENARIO_CREATE]);
        $model->account_id = $this->id;
        $model->nas_id = $this->nas_id;
        $model->operator_id = $this->operator_id;
        $model->activation_date = $d['start_date'];
        $model->deactivation_date = $d['end_date'];
        $model->is_refundable = $d['is_refundable'];
        $model->plan_id = $d['plan_id'];
        $model->plan_name = $d['plan_name'];
        $model->plan_type = $d['plan_type'];
        $model->meta_data = $d;
        $model->amount = $d['amount'];
        $model->mrp = $d['mrp'];
        $model->per_day_mrp = $d['per_day_mrp'];
        $model->per_day_amount = $d['per_day_amount'];
        $model->status = $d['status'];
        $model->mrp_tax = U::calculateTax($model->mrp);
        $model->tax = U::calculateTax($model->amount);
        if ($model->validate()) {
            $model->save();
        }
    }

    public function generateLogins() {
        $model = new User(['scenario' => User::SCENARIO_CREATE]);
        $model->name = $this->name;
        $model->username = $this->username;
        $model->password = $this->password;
        $model->mobile_no = $this->mobile_no;
        $model->email = $this->email;
        $model->user_type = C::USER_TYPE_SUBSCRIBER;
        $model->reference_id = $this->id;
        $model->designation_id = C::DESIG_SUBSC;
        $model->status = C::STATUS_ACTIVE;
        if ($model->validate()) {
            $model->save();
        } else {
            print_r($model->errors);
        }
    }

}
