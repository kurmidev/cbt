<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prospect_subscriber".
 *
 * @property int $id
 * @property string $ticket_no
 * @property string $name
 * @property string $mobile_no
 * @property string|null $email
 * @property string|null $phone_no
 * @property int|null $gender
 * @property int|null $connection_type
 * @property string|null $address
 * @property string|null $area_name
 * @property string|null $description
 * @property int $stages
 * @property int $dob
 * @property int|null $operator_id
 * @property int|null $subscriber_id
 * @property int|null $account_id
 * @property int|null $assigned_engg
 * @property int|null $is_verified
 * @property string|null $is_verified_on
 * @property int|null $is_verified_by
 * @property int|null $status
 * @property string|null $meta_data
 * @property string|null $next_follow
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class ProspectSubscriber extends \common\models\BaseModel {

    public $count;
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'prospect_subscriber';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['ticket_no', 'name', 'mobile_no', 'email', 'phone_no', 'gender', 'connection_type', 'address', 'area_name', 'description', 'stages', 'status', 'meta_data', 'next_follow', 'dob'],
            self::SCENARIO_CONSOLE => ['ticket_no', 'name', 'mobile_no', 'email', 'phone_no', 'gender', 'connection_type', 'address', 'area_name', 'description', 'stages', 'status', 'meta_data', 'next_follow', 'dob'],
            self::SCENARIO_UPDATE => ['ticket_no', 'name', 'mobile_no', 'email', 'phone_no', 'gender', 'connection_type', 'address', 'area_name', 'description', 'stages', 'status', 'meta_data', 'next_follow', 'dob'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'mobile_no', 'stages'], 'required'],
            [['gender', 'connection_type', 'stages', 'operator_id', 'subscriber_id', 'account_id', 'assigned_engg', 'is_verified', 'is_verified_by', 'status', 'added_by', 'updated_by'], 'integer'],
            [['is_verified_on', 'meta_data', 'next_follow', 'added_on', 'updated_on', 'dob'], 'safe'],
            [['ticket_no', 'name', 'mobile_no', 'email', 'phone_no', 'address', 'area_name', 'description'], 'string', 'max' => 255],
            [['ticket_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ticket_no' => 'Ticket No',
            'name' => 'Name',
            'mobile_no' => 'Mobile No',
            'email' => 'Email',
            'phone_no' => 'Phone No',
            'dob' => 'DOB',
            'gender' => 'Gender',
            'connection_type' => 'Connection Type',
            'address' => 'Address',
            'area_name' => 'Area Name',
            'description' => 'Description',
            'stages' => 'Stages',
            'operator_id' => 'Operator ID',
            'subscriber_id' => 'Subscriber ID',
            'account_id' => 'Account ID',
            'assigned_engg' => 'Assigned Engg',
            'is_verified' => 'Is Verified',
            'is_verified_on' => 'Is Verified On',
            'is_verified_by' => 'Is Verified By',
            'status' => 'Status',
            'meta_data' => 'Meta Data',
            'next_follow' => 'Next Follow',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->ticket_no = empty($this->ticket_no) ? $this->generateCode(\common\ebl\Constants::PREFIX_PROSPECT_SUSBCRIBER) : $this->ticket_no;
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     * @return ProspectSubscriberQuery the active query used by this AR class.
     */
    public static function find() {
        return new ProspectSubscriberQuery(get_called_class());
    }

}
