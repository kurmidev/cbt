<?php

namespace common\models;

use Yii;

/**
 * Model plan_policy property.
 *
 * @property integer $id
 * @property string $name
 * @property integer $days
 * @property string $start_time
 * @property string $end_time
 * @property integer $total_time
 * @property integer $limit_type
 * @property integer $limit_value
 * @property integer $limit_unit
 * @property integer $pre_upload
 * @property integer $pre_download
 * @property integer $post_upload
 * @property integer $post_download
 * @property array $extra_config
 * @property integer $status
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 *
 * @property PlanPolicyAssoc[] $planPolicyAssocs
 */
class PlanPolicy extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'plan_policy';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'days', 'start_time', 'end_time', 'total_time', 'limit_type', 'limit_value', 'limit_unit', 'pre_upload', 'pre_download', 'post_upload', 'post_download', 'extra_config', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'days', 'start_time', 'end_time', 'total_time', 'limit_type', 'limit_value', 'limit_unit', 'pre_upload', 'pre_download', 'post_upload', 'post_download', 'extra_config', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_UPDATE => ['id', 'name', 'days', 'start_time', 'end_time', 'total_time', 'limit_type', 'limit_value', 'limit_unit', 'pre_upload', 'pre_download', 'post_upload', 'post_download', 'extra_config', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if ($insert) {
            $this->total_time = \common\component\Utils::getTotalHrs($this->start_time, $this->end_time);
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) {

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['days', 'start_time', 'end_time', 'limit_type', 'limit_value', 'limit_unit', 'pre_upload', 'pre_download', 'post_upload', 'post_download'], 'required'],
            [['days', 'total_time', 'limit_type', 'limit_value', 'limit_unit', 'pre_upload', 'pre_download', 'post_upload', 'post_download', 'status', 'added_by', 'updated_by'], 'integer'],
            [['start_time', 'end_time', 'added_on', 'updated_on'], 'safe'],
            //[['extra_config'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['start_time', 'end_time', 'pre_upload', 'pre_download', 'post_upload', 'post_download'], 'unique'],
            ['days', 'in', 'range' => array_keys(\common\ebl\Constants::LABEL_DAYS_TYPES)],
            [['start_time', 'end_time'], function($attribute, $params, $validator) {
                    if (\common\component\Utils::getTotalHrs($this->start_time, $this->end_time) > "23:59:59") {
                        $this->addError($attribute, 'Invalid Start and End Time.');
                    }
                }]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanPolicyAssocs() {
        return $this->hasMany(PlanPolicyAssoc::className(), ['policy_id' => 'id']);
    }

    /**
     * with
     * @return type
     */
    function defaultWith() {
        return [];
    }

    static function extraFieldsWithConf() {
        $retun = parent::extraFieldsWithConf();
        return $retun;
    }

    /**
     * @inheritdoc
     */
    public function fields() {
        $fields = [
            'id',
            'name',
            'days',
            'start_time',
            'end_time',
            'total_time',
            'limit_type',
            'limit_value',
            'limit_unit',
            'pre_upload',
            'pre_download',
            'post_upload',
            'post_download',
            'extra_config',
            'pre_burst_threshhold' => function () {
                return $this->preBustThreshold;
            },
            'pre_burst_limit' => function () {
                return $this->preBustLimit;
            },
            'pre_burst_time' => function () {
                return $this->preBustTime;
            },
            'post_burst_threshhold' => function () {
                return $this->postBustThreshold;
            },
            'post_burst_limit' => function () {
                return $this->postBustLimit;
            },
            'post_burst_time' => function () {
                return $this->postBustTime;
            },
            'status',
            'added_on',
            'updated_on',
            'added_by',
            'updated_by',
        ];

        return array_merge(parent::fields(), $fields);
    }

    public function getAttrs() {
        return [
            'post_burst_limit',
            'post_burst_threshhold',
            'post_burst_time',
            'pre_burst_limit',
            'pre_burst_threshhold',
            'pre_burst_time',
        ];
    }

    public function getPre_burst_threshhold() {
        return \common\component\Utils::getValuesFromArray($this->extra_config, 'pre_burst_threshhold');
    }

    public function getPre_burst_time() {
        return \common\component\Utils::getValuesFromArray($this->extra_config, 'pre_burst_time');
    }

    public function getPre_burst_limit() {
        return \common\component\Utils::getValuesFromArray($this->extra_config, 'pre_burst_limit');
    }

    public function getPost_burst_threshhold() {
        return \common\component\Utils::getValuesFromArray($this->extra_config, 'post_burst_threshhold');
    }

    public function getPost_burst_time() {
        return \common\component\Utils::getValuesFromArray($this->extra_config, 'post_burst_time');
    }

    public function getPost_burst_limit() {
        return \common\component\Utils::getValuesFromArray($this->extra_config, 'post_burst_limit');
    }

    public function getLimitUnitLbl() {
        return !empty(\common\ebl\Constants::LIMIT_UNIT[$this->limit_unit]) ? \common\ebl\Constants::LIMIT_UNIT[$this->limit_unit] : 'N/A';
    }

    public function getCuttOffLimt() {
        return $this->limit_value . $this->limitUnitLbl;
    }

    /**
     * @inheritdoc
     */
    public function extraFields() {
        $fields = parent::extraFields();

        return $fields;
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'days' => 'Days',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'total_time' => 'Total Time',
            'limit_type' => 'Limit Type',
            'limit_value' => 'Limit Value',
            'limit_unit' => 'Limit Unit',
            'pre_upload' => 'Pre Upload',
            'pre_download' => 'Pre Download',
            'post_upload' => 'Post Upload',
            'post_download' => 'Post Download',
            'extra_config' => 'Extra Config',
            'status' => 'Status',
            'pre_burst_threshhold' => 'Burst Threshold',
            'pre_burst_time' => 'Burst Tme',
            'pre_burst_limit' => 'Burst Limit',
            'post_burst_threshhold' => 'Burst Threshold',
            'post_burst_time' => 'Burst Time',
            'post_burst_limit' => "Burst Limit",
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     * @return PlanPolicyQuery the active query used by this AR class.
     */
    public static function find() {
        return (new PlanPolicyQuery(get_called_class()));
    }

}
