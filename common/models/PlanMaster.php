<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * This is the model class for table "plan_master".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $display_name
 * @property int $plan_type
 * @property int $status
 * @property int $reset_type
 * @property float $reset_value
 * @property float|null $upload
 * @property float|null $download
 * @property string|null $applicable_days
 * @property float|null $post_upload
 * @property float|null $post_download
 * @property float|null $pearing_upload
 * @property float|null $pearing_download
 * @property float|null $post_pearing_upload
 * @property float|null $post_pearing_download
 * @property int $limit_type
 * @property float $limit_value
 * @property string|null $description
 * @property string|null $meta_data
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property AccountPlans[] $accountPlans
 */
class PlanMaster extends BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'plan_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'plan_type', 'billing_type', 'status', 'days', 'reset_type', 'reset_value', 'limit_type', 'limit_value'], 'required'],
            [['is_exclusive', 'is_promotional', 'plan_type', 'billing_type', 'status', 'days', 'free_days', 'reset_type', 'limit_type', 'added_by', 'updated_by'], 'integer'],
            [['reset_value', 'upload', 'download', 'post_upload', 'post_download', 'limit_value','pearing_upload','pearing_download','post_pearing_upload','post_pearing_download'], 'number'],
            [['applicable_days', 'meta_data', 'added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'display_name', 'description'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['name', 'code', 'display_name', 'is_exclusive', 'is_promotional', 'plan_type', 'billing_type', 'status', 'days', 'free_days', 'reset_type', 'reset_value', 'upload', 'download', 'applicable_days', 'post_upload', 'post_download', 'limit_type', 'limit_value', 'description', 'meta_data','pearing_upload','pearing_download','post_pearing_upload','post_pearing_download'],
            self::SCENARIO_CONSOLE => ['name', 'code', 'display_name', 'is_exclusive', 'is_promotional', 'plan_type', 'billing_type', 'status', 'days', 'free_days', 'reset_type', 'reset_value', 'upload', 'download', 'applicable_days', 'post_upload', 'post_download', 'limit_type', 'limit_value', 'description', 'meta_data','pearing_upload','pearing_download','post_pearing_upload','post_pearing_download'],
            self::SCENARIO_UPDATE => ['name', 'code', 'display_name', 'is_exclusive', 'is_promotional', 'plan_type', 'billing_type', 'status', 'days', 'free_days', 'reset_type', 'reset_value', 'upload', 'download', 'applicable_days', 'post_upload', 'post_download', 'limit_type', 'limit_value', 'description', 'meta_data','pearing_upload','pearing_download','post_pearing_upload','post_pearing_download'],
        ];
    }

    public function beforeValidate() {
        return parent::beforeValidate();
    }

    public function beforeSave($insert) {
        if(empty($this->code)){
            $prefix = C::PREFIX_PLAN;
            $this->code = $this->generateCode($prefix);
        }
        
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'display_name' => 'Display Name',
            'plan_type' => 'Plan Type',
            'billing_type' => 'Billing Type',
            'status' => 'Status',
            'reset_type' => 'Reset Type',
            'reset_value' => 'Reset Value',
            'upload' => 'Upload(MB)',
            'download' => 'Download(MB)',
            'upload_pearing' => 'Upload Pearing(MB)',
            'download_pearing' => 'Download Pearing(MB)',
            'applicable_days' => 'Applicable Days',
            'post_upload' => 'Post Upload(MB)',
            'post_download' => 'Post Download(MB)',
            'post_upload_pearing' => 'Post Upload Pearing(MB)',
            'post_download_pearing' => 'Post Download Pearing(MB)',
            'limit_type' => 'Limit Type',
            'limit_value' => 'Limit Value',
            'description' => 'Description',
            'meta_data' => 'Meta Data',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }
    /**
     * {@inheritdoc}
     * @return PlanMasterQuery the active query used by this AR class.
     */
    public static function find() {
        return new PlanMasterQuery(get_called_class());
    }

}
