<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "subscriber_shifting_log".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $customer_id
 * @property mixed $account_id
 * @property mixed $username
 * @property mixed $from_operator_id
 * @property mixed $to_operator_id
 * @property mixed $from_operator
 * @property mixed $from_operator_code
 * @property mixed $to_operator
 * @property mixed $to_operator_code
 * @property mixed $from_road_id
 * @property mixed $to_road_id
 * @property mixed $from_road
 * @property mixed $to_road
 * @property mixed $from_building_id
 * @property mixed $to_building_id
 * @property mixed $from_building
 * @property mixed $to_building
 * @property mixed $added_on
 * @property mixed $added_by
 * @property mixed $updated_by
 * @property mixed $updated_on
 */
class SubscriberShiftingLog extends \common\models\BaseMongoModel {

    /**
     * {@inheritdoc}
     */
    public static function collectionName() {
        return 'subscriber_shifting_log';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['customer_id', 'account_id', 'username', 'from_operator_id', 'to_operator_id', 'from_operator', 'from_operator_code', 'to_operator', 'to_operator_code', 'from_road_id', 'to_road_id', 'from_road', 'to_road', 'from_building_id', 'to_building_id', 'from_building', 'to_building', "cid", "name"],
            self::SCENARIO_CONSOLE => ['customer_id', 'account_id', 'username', 'from_operator_id', 'to_operator_id', 'from_operator', 'from_operator_code', 'to_operator', 'to_operator_code', 'from_road_id', 'to_road_id', 'from_road', 'to_road', 'from_building_id', 'to_building_id', 'from_building', 'to_building', "cid", "name"],
            self::SCENARIO_UPDATE => ['customer_id', 'account_id', 'username', 'from_operator_id', 'to_operator_id', 'from_operator', 'from_operator_code', 'to_operator', 'to_operator_code', 'from_road_id', 'to_road_id', 'from_road', 'to_road', 'from_building_id', 'to_building_id', 'from_building', 'to_building', "cid", "name"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes() {
        return [
            '_id',
            'customer_id',
            'account_id',
            "cid",
            "name",
            'username',
            'from_operator_id',
            'to_operator_id',
            'from_operator',
            'from_operator_code',
            'to_operator',
            'to_operator_code',
            'from_road_id',
            'to_road_id',
            'from_road',
            'to_road',
            'from_building_id',
            'to_building_id',
            'from_building',
            'to_building',
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
            [['customer_id', 'account_id', 'from_operator_id', 'to_operator_id', 'from_road_id', 'to_road_id', 'from_building_id', 'to_building_id'], 'integer'],
            [['from_operator', 'to_operator', 'from_road', 'to_road', 'from_building', 'to_building', 'cid', 'name', 'username'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            '_id' => 'ID',
            'customer_id' => 'Customer ID',
            'account_id' => 'Account ID',
            'username' => 'Username',
            'from_operator_id' => 'From Operator ID',
            'to_operator_id' => 'To Operator ID',
            'from_operator' => 'From Operator',
            'from_operator_code' => 'From Operator Code',
            'to_operator' => 'To Operator',
            'to_operator_code' => 'To Operator Code',
            'from_road_id' => 'From Road ID',
            'to_road_id' => 'To Road ID',
            'from_road' => 'From Road',
            'to_road' => 'To Road',
            'from_building_id' => 'From Building ID',
            'to_building_id' => 'To Building ID',
            'from_building' => 'From Building',
            'to_building' => 'To Building',
            'added_on' => 'Created At',
            'added_by' => 'Created By',
            'updated_by' => 'Updated By',
            'updated_on' => 'Updated At',
        ];
    }

}
