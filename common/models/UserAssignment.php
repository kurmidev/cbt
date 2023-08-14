<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_assignment".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $assigned_id
 * @property int|null $type
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class UserAssignment extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'assigned_id', 'type', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'assigned_id' => 'Assigned ID',
            'type' => 'Type',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserAssignmentQuery the active query used by this AR class.
     */
    public static function find() {
        return new UserAssignmentQuery(get_called_class());
    }

}
