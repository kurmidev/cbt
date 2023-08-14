<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * This is the model class for table "ott_plan_master".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $validity
 * @property string|null $description
 * @property int|null $status
 * @property string|null $meta_data
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class OttMaster extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ott_master';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['name', 'code', 'validity', 'description', 'status', 'meta_data'],
            self::SCENARIO_CONSOLE => ['name', 'code', 'validity', 'description', 'status', 'meta_data'],
            self::SCENARIO_UPDATE => ['name', 'validity', 'description', 'status', 'meta_data'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'code', 'validity', 'status'], 'required'],
            [['validity', 'status', 'added_by', 'updated_by'], 'integer'],
            [['meta_data', 'added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'description'], 'string', 'max' => 255],
            [['code'], 'unique'],
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
            'validity' => 'Validity',
            'description' => 'Description',
            'status' => 'Status',
            'meta_data' => 'Meta Data',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return OttPlanMasterQuery the active query used by this AR class.
     */
    public static function find() {
        return new OttMasterQuery(get_called_class());
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            $this->addInBouquetAsset();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function addInBouquetAsset() {
        $model = BouquetAssets::findOne(['mapped_id' => $this->id, 'type' => C::BOUQUET_ASSET_OTT]);
        if (!$model instanceof BouquetAssets) {
            $model = new BouquetAssets(['scenario' => BouquetAssets::SCENARIO_CREATE]);
        } else {
            $model->scenario = BouquetAssets::SCENARIO_UPDATE;
        }
        $model->name = $this->name;
        $model->code = $this->code;
        $model->type = C::BOUQUET_ASSET_OTT;
        $model->price = 0;
        $model->status = $this->status;
        $model->mapped_id = $this->id;
        if ($model->validate() && $model->save()) {
            return true;
        }
        return false;
    }


}
