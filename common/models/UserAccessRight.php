<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "user_access_right".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $role_name
 * @property mixed $items
 * @property mixed $added_on
 * @property mixed $updated_on
 * @property mixed $added_by
 * @property mixed $updated_by
 */
class UserAccessRight extends \common\models\BaseMongoModel {

    /**
     * {@inheritdoc}
     */
    public static function collectionName() {
        return 'user_access_right';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['_id', 'role_name', 'items'],
            self::SCENARIO_CONSOLE => ['_id', 'role_name', 'items'],
            self::SCENARIO_UPDATE => ['_id', 'role_name', 'items'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes() {
        return [
            '_id',
            'role_name',
            'items',
            'added_on',
            'updated_on',
            'added_by',
            'updated_by',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['role_name', 'items', 'added_on', 'updated_on', 'added_by', 'updated_by'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            '_id' => 'ID',
            'role_name' => 'Role Name',
            'items' => 'Items',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

}
