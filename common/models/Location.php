<?php

namespace common\models;

use Yii;
use common\ebl\Constants;

/**
 * Model location property.
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $type
 * @property integer $state_id
 * @property integer $city_id
 * @property integer $area_id
 * @property integer $road_id
 * @property integer $status
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 */
class Location extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'location';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['name', 'code', 'type', 'state_id', 'city_id', 'area_id', 'road_id', 'status'],
            self::SCENARIO_CONSOLE => ['name', 'code', 'type', 'state_id', 'city_id', 'area_id', 'road_id', 'status'],
            self::SCENARIO_UPDATE => ['name', 'code', 'type', 'state_id', 'city_id', 'area_id', 'road_id', 'status'],
        ];
    }

    public function beforeValidate() {
        if ($this->scenario == self::SCENARIO_CREATE) {
            $prefix = Constants::PREFIX_BUILDING;
            if ($this->type == Constants::LOCATION_AREA) {
                $prefix = Constants::PREFIX_AREA;
                $this->road_id = 0;
            } else if ($this->type == Constants::LOCATION_CITY) {
                $prefix = Constants::PREFIX_CITY;
                $this->road_id = $this->area_id = 0;
            } else if ($this->type == Constants::LOCATION_ROAD) {
                $prefix = Constants::PREFIX_ROAD;
                $this->road_id = 0;
            } else if ($this->type == Constants::LOCATION_STATE) {
                $prefix = Constants::PREFIX_STATE;
                $this->road_id = $this->area_id = $this->city_id = 0;
            }
            $this->code = empty($this->code) ? $this->generateCode($prefix) : $this->code;
        }

        if (in_array($this->scenario, [self::SCENARIO_CREATE, self::SCENARIO_UPDATE])) {
            $this->setExtraData();
        }
        return parent::beforeValidate();
    }

    public function setExtraData() {
        if ($this->type == Constants::LOCATION_AREA && !empty($this->city_id)) {
            $this->state_id = self::findOne(['id' => $this->city_id])->state_id;
        } else if ($this->type == Constants::LOCATION_ROAD && !empty($this->area_id)) {
            $obj = self::findOne(['id' => $this->area_id]);
            if ($obj instanceof Location) {
                $this->state_id = $obj->state_id;
                $this->city_id = $obj->city_id;
            }
        } else if ($this->type == Constants::LOCATION_BUILDING && !empty($this->road_id)) {
            $obj = self::findOne(['id' => $this->road_id]);
            if ($obj instanceof Location) {
                $this->state_id = $obj->state_id;
                $this->city_id = $obj->city_id;
                $this->area_id = $obj->area_id;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
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
            [['name', 'code', 'type'], 'required'],
            [['type', 'state_id', 'city_id', 'area_id', 'road_id', 'status'], 'integer'],
            [['type'], 'in', 'range' => array_keys(Constants::LABEL_LOCATION)],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['name','type'], 'unique', 'targetAttribute' => ['name', 'type']],
            ['state_id', 'required', 'when' => function ($model) {
                    return $model->type == Constants::LOCATION_CITY;
                }],
            [['state_id', 'city_id'], 'required', 'when' => function ($model) {
                    return $model->type == Constants::LOCATION_AREA;
                }],
            [['state_id', 'city_id', 'area_id'], 'required', 'when' => function ($model) {
                    return $model->type == Constants::LOCATION_ROAD;
                }],
            [['state_id', 'city_id', 'area_id', 'road_id'], 'required', 'when' => function ($model) {
                    return $model->type == Constants::LOCATION_BUILDING;
                }],
        ];
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

    function getDisplay_name() {
        $name = "";
        switch ($this->type) {
            case Constants::LOCATION_ROAD:
                $name .= "Area : " . $this->area->name;
            case Constants::LOCATION_AREA;
                $name .= "City : " . $this->city->name;
            case Constants::LOCATION_CITY:
                $name .= "State : " . $this->state->name;
                break;
        }
        return $name;
    }

    /**
     * @inheritdoc
     */
    public function fields() {
        $fields = [
            'id',
            'name',
            'code',
            'type',
            'state_id',
            'city_id',
            'area_id',
            'road_id',
            'status',
            'added_on',
            'updated_on',
            'added_by',
            'updated_by'
        ];

        return array_merge(parent::fields(), $fields);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id',
            'name' => 'Name',
            'code' => "Code",
            'type' => "Location Type",
            'state_id' => "State",
            'city_id' => "City",
            'area_id' => "Area",
            'road_id' => "Road",
            'status' => "Status",
            'added_on',
            'updated_on',
            'added_by',
            'updated_by'
        ];
    }

    /**
     * @inheritdoc
     */
    public function extraFields() {
        $fields = parent::extraFields();

        $fields['state_lbl'] = function() {
            return !empty($this->state) ? $this->state->name : null;
        };
        $fields['city_lbl'] = function() {
            return !empty($this->city) ? $this->city->name : null;
        };
        $fields['area_lbl'] = function() {
            return !empty($this->area) ? $this->area->name : null;
        };
        $fields['road_lbl'] = function() {
            return !empty($this->road) ? $this->road->name : null;
        };
        return $fields;
    }

    public function getState() {
        return $this->hasOne(Location::class, ['id' => 'state_id'])->andWhere(['type' => Constants::LOCATION_STATE]);
    }

    public function getCity() {
        return $this->hasOne(Location::class, ['id' => 'city_id'])->andWhere(['type' => Constants::LOCATION_CITY]);
    }

    public function getArea() {
        return $this->hasOne(Location::class, ['id' => 'area_id'])->andWhere(['type' => Constants::LOCATION_AREA]);
    }

    public function getRoad() {
        return $this->hasOne(Location::class, ['id' => 'road_id'])->andWhere(['type' => Constants::LOCATION_ROAD]);
    }

    /**
     * @inheritdoc
     * @return LocationQuery the active query used by this AR class.
     */
    public static function find() {
        return new LocationQuery(get_called_class());
    }

}
