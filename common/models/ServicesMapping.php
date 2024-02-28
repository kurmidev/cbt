<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "services_mapping".
 *
 * @property int $id
 * @property int $service_id
 * @property int $parent_id
 * @property int $child_id
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property Services $child
 * @property Services $parent
 */
class ServicesMapping extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services_mapping';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ["*"],
            self::SCENARIO_CREATE => ['service_id', 'parent_id', 'child_id'],
            self::SCENARIO_UPDATE => ['service_id', 'parent_id', 'child_id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'parent_id', 'child_id'], 'required'],
            [['service_id', 'parent_id', 'child_id', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['child_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::class, 'targetAttribute' => ['child_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::class, 'targetAttribute' => ['parent_id' => 'id']],
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
            'parent_id' => 'Parent ID',
            'child_id' => 'Child ID',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Child]].
     *
     * @return \yii\db\ActiveQuery|ServicesQuery
     */
    public function getChild()
    {
        return $this->hasOne(Services::class, ['id' => 'child_id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery|ServicesQuery
     */
    public function getParent()
    {
        return $this->hasOne(Services::class, ['id' => 'parent_id']);
    }

    /**
     * {@inheritdoc}
     * @return ServicesMappingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServicesMappingQuery(get_called_class());
    }
}
