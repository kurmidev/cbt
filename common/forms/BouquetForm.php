<?php

namespace common\forms;

use common\ebl\Constants as C;
use common\component\Utils as U;
use common\models\Bouquet;
use common\models\RateMaster;

class BouquetForm extends \yii\base\Model {

    use \common\models\BaseTraits;

    public $id;
    public $name;
    public $rates;
    public $description;
    public $status;
    public $days;
    public $bill_type;
    public $is_online;
    public $type;
    public $asset_mapping;

    public function scenarios() {
        return [
            Bouquet::SCENARIO_CREATE => ['id', 'name', 'rates', 'description', 'status', 'days', 'bill_type', 'is_online', 'type', 'asset_mapping'],
            Bouquet::SCENARIO_CONSOLE => ['id', 'name', 'rates', 'description', 'status', 'days', 'bill_type', 'is_online', 'type', 'asset_mapping'],
            Bouquet::SCENARIO_UPDATE => ['id', 'name', 'rates', 'description', 'status', 'days', 'bill_type', 'is_online', 'type', 'asset_mapping'],
        ];
    }

    public function rules(): array {
        $dynamic_validate = (new \yii\base\DynamicModel(['name', 'amount', 'mrp']))
                ->addRule(['name', 'amount', 'mrp'], 'required')
                ->addRule(['amount', 'mrp'], "number");

        return [
            [['name', 'rates', 'status', 'days', 'bill_type', 'is_online', 'type', 'asset_mapping'], 'required'],
            [['description', 'name'], 'string'],
            [['status', 'is_online', 'type', 'bill_type'], 'integer'],
            [['rates'], 'ValidateMulti', 'params' => ['isMulti' => TRUE, 'ValidationModel' => $dynamic_validate, 'allowEmpty' => FALSE]],
            ['asset_mapping', 'validateAssetMapping']
        ];
    }

    public function validateAssetMapping($attribute, $params, $validator) {
        switch ($this->type) {
            case C::PLAN_TYPE_BASE:
                if (empty($this->asset_mapping[C::BOUQUET_ASSET_INTERNET])) {
                    $this->addError("asset_mapping[" . C::BOUQUET_ASSET_INTERNET . "]", "For base, internet plan is required.");
                    return false;
                }
                break;
            case C::PLAN_TYPE_ADDONS:
                if (empty($this->asset_mapping[C::BOUQUET_ASSET_INTERNET]) && empty($this->asset_mapping[C::BOUQUET_ASSET_OTT])) {
                    $this->addError("asset_mapping[" . C::BOUQUET_ASSET_INTERNET . "]", "For addons, either internet or OTT plan is required.");
                    return false;
                }
                break;
            default :
                break;
        }
    }

    public function beforeValidate() {
        return parent::beforeValidate();
    }

    public function save($runValidation = true, $attributeNames = null) {
        if (!$this->hasErrors()) {
            if ($this->id) {
                return $this->update();
            } else {
                return $this->create();
            }
        }
        return false;
    }

    public function create() {
        $model = new Bouquet(['scenario' => Bouquet::SCENARIO_CREATE]);
        $model->load($this->attributes, '');
        if ($model->validate() && $model->save()) {
            $this->id = $model->id;
            $this->addRates($model->id);
            $this->assetMapping($model->id);
            return TRUE;
        } else {
            $this->addErrors($model->errors);
        }
        return FALSE;
    }

    public function update() {
        $model = Bouquet::findOne($this->id);
        if ($model instanceof Bouquet) {
            $model->scenario = Bouquet::SCENARIO_UPDATE;
            $model->load($this->attributes, '');
            if ($model->validate() && $model->save()) {
                $this->id = $model->id;
                $this->addRates($model->id);
                $this->assetMapping($model->id);
                return TRUE;
            } else {
                $this->addErrors($model->errors);
            }
        }
        return false;
    }

    public function assetMapping($bouquet_id) {
        if (!empty($bouquet_id) && !empty($this->asset_mapping)) {
            \common\models\BouquetAssetMapping::deleteAll(['bouquet_id' => $bouquet_id]);
            foreach ($this->asset_mapping as $assets) {
                if (is_array($assets)) {
                    foreach ($assets as $asset_id) {
                        $d = $this->insertAsset($bouquet_id, $asset_id);
                    }
                } else {
                    $d = $this->insertAsset($bouquet_id, $assets);
                }
            }
        }
    }

    public function insertAsset($bouquet_id, $asset_id) {
        $model = \common\models\BouquetAssetMapping::findOne(['bouquet_id' => $bouquet_id, 'asset_id' => $asset_id]);
        if (!$model instanceof \common\models\BouquetAssetMapping) {
            $model = new \common\models\BouquetAssetMapping(['scenario' => \common\models\BouquetAssetMapping::SCENARIO_CREATE]);
            $model->bouquet_id = $bouquet_id;
            $model->asset_id = $asset_id;
            if ($model->validate() && $model->save()) {
                return true;
            }
        }
        return false;
    }

    public function addRates($bouquet_id) {
        $rateObj = RateMaster::find()->where(['assoc_id' => $bouquet_id, 'type' => C::RATE_TYPE_BOUQUET])->indexBy('name')->all();
        $model = null;
        $delRate = [];
        foreach ($this->rates as $rate) {
            if (!empty($rateObj[$rate['name']])) {
                $model = $rateObj[$rate['name']];
                $model->scenario = RateMaster::SCENARIO_UPDATE;
            } else {
                $model = new RateMaster(['scenario' => RateMaster::SCENARIO_CREATE]);
                $model->name = $rate['name'];
                $model->assoc_id = $bouquet_id;
                $model->type = C::RATE_TYPE_BOUQUET;
            }
            $model->amount = $rate['amount'];
            $model->mrp = $rate['mrp'];
            $model->tax = U::calculateTax($model->amount);
            $model->mrp_tax = U::calculateTax($model->mrp);

            if ($model->validate() && $model->save()) {
                $delRate[] = $model->id;
            }
        }
        if (!empty($delRate)) {
            $del_id = RateMaster::find()->where(['assoc_id' => $bouquet_id, 'type' => C::RATE_TYPE_BOUQUET])
                            ->andWhere(['not', ['id' => $delRate]])
                            ->indexBy('id')->all();
            if (!empty($del_id)) {
                foreach ($del_id as $model) {
                    $model->delete();
                }
            }
        }
    }

}
