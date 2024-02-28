<?php

namespace common\forms;

use common\models\PlanMaster;
use common\models\RateMaster;
use common\ebl\Constants as C;
use common\component\Utils as U;
use common\models\BouquetAssets;

class PlanForm extends \yii\base\Model {

    use \common\models\BaseTraits;

    public $id;
    public $name;
    public $display_name;
    public $status;
    public $plan_type;
    public $reset_type;
    public $reset_value;
    public $upload;
    public $download;
    public $applicable_days;
    public $post_upload;
    public $post_download;
    public $limit_type;
    public $limit_value;
    public $description;
    public $download_pearing;
    public $upload_pearing;
    public $post_upload_pearing;
    public $post_download_pearing;

    //public $rates;

    public function scenarios() {
        return [
            PlanMaster::SCENARIO_CREATE => ['id', 'name', 'display_name', 'plan_type', 'status',  'reset_type', 'reset_value', 'upload', 'download', 'applicable_days', 'post_upload', 'post_download', 'limit_type', 'limit_value', 'description','pearing_upload','pearing_download','post_pearing_upload','post_pearing_download'],
            PlanMaster::SCENARIO_CONSOLE => ['id', 'name', 'display_name', 'plan_type', 'status', 'reset_type', 'reset_value', 'upload', 'download', 'applicable_days', 'post_upload', 'post_download', 'limit_type', 'limit_value', 'description','pearing_upload','pearing_download','post_pearing_upload','post_pearing_download'],
            PlanMaster::SCENARIO_UPDATE => ['id', 'name', 'display_name', 'plan_type', 'status',  'reset_type', 'reset_value', 'upload', 'download', 'applicable_days', 'post_upload', 'post_download', 'limit_type', 'limit_value', 'description','pearing_upload','pearing_download','post_pearing_upload','post_pearing_download'],
        ];
    }

    public function rules() {
        return [
            [['name', 'plan_type', 'status', 'reset_type', 'reset_value', 'limit_type', 'limit_value', 'rates'], 'required'],
            [[ 'plan_type', 'billing_type', 'status', 'reset_type', 'limit_type', 'added_by', 'updated_by'], 'integer'],
            [['reset_value', 'upload', 'download', 'post_upload', 'post_download', 'limit_value','pearing_upload','pearing_download','post_pearing_upload','post_pearing_download'], 'number'],
            [['applicable_days', 'meta_data', 'added_on', 'updated_on'], 'safe'],
            [['name', 'display_name', 'description'], 'string', 'max' => 255],
        ];
    }

    public function beforeValidate() {
        return parent::beforeValidate();
    }

    public function attributeLabels() {
        return (new PlanMaster())->attributeLabels();
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
        $model = new PlanMaster(['scenario' => PlanMaster::SCENARIO_CREATE]);
        $model->load($this->attributes, '');
        if ($model->validate() && $model->save()) {
            $this->id = $model->id;
            $this->addInBouquetAsset($model);
            return TRUE;
        } else {
            $this->addErrors($model->errors);
        }
        return FALSE;
    }

    public function update() {
        $model = PlanMaster::findOne($this->id);
        if ($model instanceof PlanMaster) {
            $model->scenario = PlanMaster::SCENARIO_UPDATE;
            $model->load($this->attributes, '');
            if ($model->validate() && $model->save()) {
                $this->id = $model->id;
                $this->addInBouquetAsset($model);
                return TRUE;
            } else {
                $this->addErrors($model->errors);
            }
        }
        return false;
    }

    public function addInBouquetAsset(PlanMaster $plan) {
        $model = BouquetAssets::findOne(['mapped_id' => $plan->id, 'type' => C::BOUQUET_ASSET_INTERNET]);
        if (!$model instanceof BouquetAssets) {
            $model = new BouquetAssets(['scenario' => BouquetAssets::SCENARIO_CREATE]);
        } else {
            $model->scenario = BouquetAssets::SCENARIO_UPDATE;
        }
        $model->name = $plan->name;
        $model->code = $plan->code;
        $model->type = C::BOUQUET_ASSET_INTERNET;
        $model->price = 0;
        $model->status = $plan->status;
        $model->mapped_id = $plan->id;
        if ($model->validate() && $model->save()) {
            return true;
        }

        return false;
    }

}
