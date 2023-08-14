<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rate_master".
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property int $assoc_id
 * @property float|null $amount
 * @property float|null $tax
 * @property float|null $mrp
 * @property float|null $mrp_tax
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class RateMaster extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rate_master';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'type', 'assoc_id', 'amount', 'tax', 'mrp', 'mrp_tax'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'type', 'assoc_id', 'amount', 'tax', 'mrp', 'mrp_tax'],
            self::SCENARIO_UPDATE => ['id', 'name', 'type', 'assoc_id', 'amount', 'tax', 'mrp', 'mrp_tax'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'type', 'assoc_id'], 'required'],
            [['type', 'assoc_id', 'added_by', 'updated_by'], 'integer'],
            [['amount', 'tax', 'mrp', 'mrp_tax'], 'number'],
            [['added_on', 'updated_on'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'assoc_id' => 'Assoc ID',
            'amount' => 'Amount',
            'tax' => 'Tax',
            'mrp' => 'Mrp',
            'mrp_tax' => 'Mrp Tax',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getTotal() {
        return $this->amount + $this->tax;
    }

    public function getMrp_Total() {
        return $this->mrp + $this->mrp_tax;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan() {
        return $this->hasOne(PlanMaster::className(), ['id' => 'assoc_id']);
    }

    /**
     * {@inheritdoc}
     * @return RateMasterQuery the active query used by this AR class.
     */
    public static function find() {
        return new RateMasterQuery(get_called_class());
    }

}
