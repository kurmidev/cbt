<?php

namespace common\models;

use common\models\BaseModel;
use Yii;


/**
 * This is the model class for table "language".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $status
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class Language extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'language';
    }

    public function scenarios(){
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['name', 'code',  'status'],
            self::SCENARIO_CONSOLE => ['name', 'code','status'],
            self::SCENARIO_UPDATE => ['name', 'code', 'status'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'status'], 'required'],
            [['status', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
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
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return LanguageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LanguageQuery(get_called_class());
    }
}
