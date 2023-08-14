<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bouquet_assets".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $type
 * @property float|null $price
 * @property int $status
 * @property int $mapped_id
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class BouquetAssets extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bouquet_assets';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'code', 'status', 'type', 'price', 'mapped_id', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'code', 'status', 'type', 'price', 'mapped_id', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_UPDATE => ['id', 'name', 'code', 'status', 'type', 'price', 'mapped_id', 'added_on', 'updated_on', 'added_by', 'updated_by'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'code', 'type', 'status', 'mapped_id'], 'required'],
            [['type', 'status', 'mapped_id', 'added_by', 'updated_by'], 'integer'],
            [['price'], 'number'],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
            [['type', 'mapped_id'], 'unique', 'targetAttribute' => ['type', 'mapped_id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'type' => 'Type',
            'price' => 'Price',
            'status' => 'Status',
            'mapped_id' => 'Mapped ID',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return BouquetAssetsQuery the active query used by this AR class.
     */
    public static function find() {
        return new BouquetAssetsQuery(get_called_class());
    }

}
