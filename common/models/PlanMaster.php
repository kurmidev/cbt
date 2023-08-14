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
 * @property int $is_exclusive
 * @property int $is_promotional
 * @property int $plan_type
 * @property int $billing_type
 * @property int $status
 * @property int $days
 * @property int|null $free_days
 * @property int $reset_type
 * @property float $reset_value
 * @property float|null $upload
 * @property float|null $download
 * @property string|null $applicable_days
 * @property float|null $post_upload
 * @property float|null $post_download
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
            [['reset_value', 'upload', 'download', 'post_upload', 'post_download', 'limit_value'], 'number'],
            [['applicable_days', 'meta_data', 'added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'display_name', 'description'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['name', 'code', 'display_name', 'is_exclusive', 'is_promotional', 'plan_type', 'billing_type', 'status', 'days', 'free_days', 'reset_type', 'reset_value', 'upload', 'download', 'applicable_days', 'post_upload', 'post_download', 'limit_type', 'limit_value', 'description', 'meta_data'],
            self::SCENARIO_CONSOLE => ['name', 'code', 'display_name', 'is_exclusive', 'is_promotional', 'plan_type', 'billing_type', 'status', 'days', 'free_days', 'reset_type', 'reset_value', 'upload', 'download', 'applicable_days', 'post_upload', 'post_download', 'limit_type', 'limit_value', 'description', 'meta_data'],
            self::SCENARIO_UPDATE => ['name', 'code', 'display_name', 'is_exclusive', 'is_promotional', 'plan_type', 'billing_type', 'status', 'days', 'free_days', 'reset_type', 'reset_value', 'upload', 'download', 'applicable_days', 'post_upload', 'post_download', 'limit_type', 'limit_value', 'description', 'meta_data'],
        ];
    }

    public function beforeValidate() {
        $this->is_promotional = $this->is_exclusive = 0;
        return parent::beforeValidate();
    }

    public function beforeSave($insert) {
        $prefix = \common\ebl\Constants::PREFIX_PLAN;
        $this->code = empty($this->code) ? $this->generateCode($prefix) : $this->code;
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
            'is_exclusive' => 'Is Exclusive',
            'is_promotional' => 'Is Promotional',
            'plan_type' => 'Plan Type',
            'billing_type' => 'Billing Type',
            'status' => 'Status',
            'days' => 'Days',
            'free_days' => 'Free Days(optionals)',
            'reset_type' => 'Reset Type',
            'reset_value' => 'Reset Value',
            'upload' => 'Upload(MB)',
            'download' => 'Download(MB)',
            'applicable_days' => 'Applicable Days',
            'post_upload' => 'Post Upload(MB)',
            'post_download' => 'Post Download(MB)',
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

    public function getAttrs() {
        return [
            'rates' => 'rates',
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
