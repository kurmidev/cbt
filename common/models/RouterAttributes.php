<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "router_attributes".
 *
 * @property int $id
 * @property int|null $router_id
 * @property string|null $name
 * @property string|null $op
 * @property string|null $group
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class RouterAttributes extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'router_attributes';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['router_id', 'name', 'op', 'group'],
            self::SCENARIO_CONSOLE => ['router_id', 'name', 'op', 'group'],
            self::SCENARIO_UPDATE => ['router_id', 'name', 'op', 'group'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['router_id', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'op', 'group'], 'string', 'max' => 255],
            [['router_id', 'name', 'group'], 'unique', 'targetAttribute' => ['router_id', 'name', 'group']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'router_id' => 'Router ID',
            'name' => 'Name',
            'op' => 'Op',
            'group' => 'Group',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return RouterAttributesQuery the active query used by this AR class.
     */
    public static function find() {
        return new RouterAttributesQuery(get_called_class());
    }

}
