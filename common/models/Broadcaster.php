<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "broadcaster".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $contact_no
 * @property string|null $address
 * @property int $status
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class Broadcaster extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'broadcaster';
    }

    public function scenarios(){
        return [
            self::SCENARIO_DEFAULT => ["*"],
            self::SCENARIO_CREATE => ['name', 'code', 'contact_no', 'status','address'],
            self::SCENARIO_UPDATE => ['name', 'code', 'contact_no', 'status','address'],
            self::SCENARIO_CONSOLE => ['name', 'code', 'contact_no', 'status','address'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'contact_no', 'status'], 'required'],
            [['status', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'contact_no', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'contact_no' => 'Contact No',
            'address' => 'Address',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return BroadcasterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BroadcasterQuery(get_called_class());
    }
}
