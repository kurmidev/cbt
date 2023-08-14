<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bouquet_asset_mapping".
 *
 * @property int $id
 * @property int $bouquet_id
 * @property int $asset_id
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property Bouquet $bouquet
 */
class BouquetAssetMapping extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bouquet_asset_mapping';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ["*"],
            self::SCENARIO_CREATE => ['bouquet_id', 'asset_id'],
            self::SCENARIO_UPDATE => ['bouquet_id', 'asset_id'],
            self::SCENARIO_CONSOLE => ['bouquet_id', 'asset_id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bouquet_id', 'asset_id'], 'required'],
            [['bouquet_id', 'asset_id', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['bouquet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bouquet::className(), 'targetAttribute' => ['bouquet_id' => 'id']],
            [['asset_id'], 'exist', 'skipOnError' => true, 'targetClass' => BouquetAssets::className(), 'targetAttribute' => ['asset_id' => 'id']],
            [['bouquet_id', 'asset_id'], 'unique', 'targetAttribute' => ['bouquet_id', 'asset_id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bouquet_id' => 'Bouquet ID',
            'asset_id' => 'Asset ID',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Bouquet]].
     *
     * @return \yii\db\ActiveQuery|BouquetQuery
     */
    public function getBouquet() {
        return $this->hasOne(Bouquet::className(), ['id' => 'bouquet_id']);
    }

    public function getBouquetAsset() {
        return $this->hasOne(BouquetAssets::className(), ['id' => 'asset_id']);
    }

    /**
     * {@inheritdoc}
     * @return BouquetAssetMappingQuery the active query used by this AR class.
     */
    public static function find() {
        return new BouquetAssetMappingQuery(get_called_class());
    }

}
