<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * This is the model class for table "bouquet".
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string|null $description
 * @property int $status
 * @property int $days
 * @property int $bill_type
 * @property string|null $meta_data
 * @property int $is_online
 * @property int $type
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class Bouquet extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bouquet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'status', 'days', 'bill_type', 'type'], 'required'],
            [['status', 'days', 'bill_type', 'is_online', 'type', 'added_by', 'updated_by','free_days'], 'integer'],
            [['meta_data', 'added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'description'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'code', 'status', 'bill_type', 'is_online', 'type', 'days', 'meta_data', 'description', 'added_on', 'updated_on', 'added_by', 'updated_by','free_days'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'code', 'status', 'bill_type', 'is_online', 'type', 'days', 'meta_data', 'description', 'added_on', 'updated_on', 'added_by', 'updated_by','free_days'],
            self::SCENARIO_UPDATE => ['id', 'name', 'code', 'status', 'bill_type', 'is_online', 'type', 'days', 'meta_data', 'description', 'added_on', 'updated_on', 'added_by', 'updated_by','free_days'],
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
            'description' => 'Description',
            'status' => 'Status',
            'days' => 'Days',
            'free_days'=> 'Free Days',
            'bill_type' => 'Bill Type',
            'meta_data' => 'Meta Data',
            'is_online' => 'Is Online',
            'type' => 'Type',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return BouquetQuery the active query used by this AR class.
     */
    public static function find() {
        return new BouquetQuery(get_called_class());
    }

    public function beforeSave($insert) {

        if ($this->scenario == self::SCENARIO_CREATE) {
            $this->code = empty($this->code) ? $this->generateCode(\common\ebl\Constants::PREFIX_BOUQUET) : $this->code;
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
    }

    public function getBouquetMapped() {
        return $this->hasMany(BouquetAssetMapping::class, ['bouquet_id' => 'id'])
                        ->with(['bouquetAsset']);
    }

    public function getAsset_mapping() {
        if (!empty($this->bouquetMapped)) {
            return \yii\helpers\ArrayHelper::map($this->bouquetMapped, "asset_id", 'asset_id', 'bouquetAsset.type');
        }
        return [];
    }

    public function getAttrs() {
        return [
            'rates' => 'rates',
            'asset_mapping' => 'asset_mapping'
        ];
    }

    public function getBouquetAssoc() {
        return $this->hasMany(OperatorRates::class, ["assoc_id" => "id"])
                        ->andWhere(["type" => C::RATE_TYPE_BOUQUET2]);
    }

    public static function getAssignedBouquet($operator_id, $retType = 1, $plan_type = C::PLAN_TYPE_BASE) {
        $query = self::find()->alias('p')
                ->innerJoin('operator_rates b', 'p.id=b.assoc_id and b.type=' . C::RATE_TYPE_BOUQUET)
                ->defaultCondition()->andWhere(['p.status' => C::STATUS_ACTIVE])
                ->andFilterWhere(['b.operator_id' => $operator_id])
                ->andFilterWhere(['p.type' => $plan_type]);
        if ($retType == 1) {
            $query->asArray();
        }

        return $query->all();
    }

    public function getRates() {
        return $this->hasMany(RateMaster::class, ['assoc_id' => 'id'])
                        ->andOnCondition(['type' => C::RATE_TYPE_BOUQUET]);
    }

    /**
     * Gets query for [[AccountPlans]].
     *
     * @return \yii\db\ActiveQuery|AccountPlansQuery
     */
    public function getAccountBouquet() {
        return $this->hasMany(AccountPlans::className(), ['plan_id' => 'id']);
    }

}
