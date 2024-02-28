<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $service_type
 * @property int $type
 * @property int|null $broadcaster_id
 * @property int|null $language_id
 * @property int|null $genre_id
 * @property int|null $is_alacarte
 * @property int|null $is_fta
 * @property float $rate
 * @property string|null $description
 * @property string|null $meta_data
 * @property int $status
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property ServicesMapping[] $servicesMappings
 * @property ServicesMapping[] $servicesMappings0
 * @property ServicesSettings[] $servicesSettings
 */
class Services extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['*'],
            self::SCENARIO_CREATE => ['name', 'code', 'service_type', 'type', 'rate', 'status', 'broadcaster_id', 'language_id', 'genre_id', 'is_alacarte', 'is_fta'],
            self::SCENARIO_UPDATE => ['name', 'code', 'service_type', 'type', 'rate', 'status', 'broadcaster_id', 'language_id', 'genre_id', 'is_alacarte', 'is_fta'],
            self::SCENARIO_CONSOLE => ['name', 'code', 'service_type', 'type', 'rate', 'status', 'broadcaster_id', 'language_id', 'genre_id', 'is_alacarte', 'is_fta']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name',  'service_type', 'type', 'rate', 'status'], 'required'],
            [['service_type', 'type', 'broadcaster_id', 'language_id', 'genre_id', 'is_alacarte', 'is_fta', 'status', 'added_by', 'updated_by'], 'integer'],
            [['rate'], 'number'],
            [['meta_data', 'added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'description'], 'string', 'max' => 255],
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
            'service_type' => 'Service Type',
            'type' => 'Type',
            'broadcaster_id' => 'Broadcaster ID',
            'language_id' => 'Language ID',
            'genre_id' => 'Genre ID',
            'is_alacarte' => 'Is Alacarte',
            'is_fta' => 'Is Fta',
            'rate' => 'Rate',
            'description' => 'Description',
            'meta_data' => 'Meta Data',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[ServicesMappings]].
     *
     * @return \yii\db\ActiveQuery|ServicesMappingQuery
     */
    public function getServicesMappings()
    {
        return $this->hasMany(ServicesMapping::class, ['child_id' => 'id']);
    }

    /**
     * Gets query for [[ServicesSettings]].
     *
     * @return \yii\db\ActiveQuery|ServicesSettingsQuery
     */
    public function getServicesSettings()
    {
        return $this->hasMany(ServicesSettings::class, ['service_id' => 'id']);
    }

    /**
     * Gets query for [[Boradcaster]].
     *
     * @return \yii\db\ActiveQuery|BoradcasterQuery
     */
    public function getBroadcaster()
    {
        return $this->hasOne(Broadcaster::class, ['id' => 'broadcaster_id']);
    }

    /**
     * Gets query for [[Genre]].
     *
     * @return \yii\db\ActiveQuery|GenreQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::class, ['id' => 'genre_id']);
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery|LanguageQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'genre_id']);
    }


    /**
     * {@inheritdoc}
     * @return ServicesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServicesQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {

        if ($this->scenario == self::SCENARIO_CREATE) {
            $prefix = "";
            switch ($this->service_type) {
                case C::SERVICE_TYPE_CHANNEL:
                    $prefix = C::PREFIX_SERVICE_CHANNEL;
                    break;
                case C::SERVICE_TYPE_PACKAGE:
                    $prefix = C::PREFIX_SERVICE_PACKAGE;
                    break;
                case C::SERVICE_TYPE_OTT:
                    $prefix = C::PREFIX_SERVICE_OTT;
                    break;
                default:
                    $prefix = "";
                    break;
            }
            $this->code = empty($this->code) ? $this->generateCode($prefix) : $this->code;
        }
        return parent::beforeSave($insert);
    }
}
