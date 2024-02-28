<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "services_settings".
 *
 * @property int $id
 * @property int $service_id
 * @property int $plugin_id
 * @property string $plugin_code
 * @property string|null $other_codes
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property Services $service
 */
class ServicesSettings extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'plugin_id', 'plugin_code'], 'required'],
            [['service_id', 'plugin_id', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['plugin_code', 'other_codes'], 'string', 'max' => 255],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::class, 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    public function scenarios(){
        return [
            self::SCENARIO_DEFAULT => ["*"],
            self::SCENARIO_CONSOLE => ['service_id', 'plugin_id', 'plugin_code','other_codes'],
            self::SCENARIO_CREATE => ['service_id', 'plugin_id', 'plugin_code','other_codes'],
            self::SCENARIO_UPDATE => ['service_id', 'plugin_id', 'plugin_code','other_codes'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'Service ID',
            'plugin_id' => 'Plugin ID',
            'plugin_code' => 'Plugin Code',
            'other_codes' => 'Other Codes',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery|ServicesQuery
     */
    public function getService()
    {
        return $this->hasOne(Services::class, ['id' => 'service_id']);
    }

    /**
     * {@inheritdoc}
     * @return ServicesSettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServicesSettingsQuery(get_called_class());
    }
}
