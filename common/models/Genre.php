<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "genre".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property int $status
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class Genre extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genre';
    }

    public function scenarios(){
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['name', 'code',  'status','description'],
            self::SCENARIO_CONSOLE => ['name', 'code','status','description'],
            self::SCENARIO_UPDATE => ['name', 'code', 'status','description']
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'description', 'status'], 'required'],
            [['status', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'description'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique'],
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
            'description' => 'Description',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return GenreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GenreQuery(get_called_class());
    }
}
