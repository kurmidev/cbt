<?php

namespace common\ebl\jobs;

use common\models\Location;
use common\ebl\Constants as C;
use common\models\Operator;

class LocationMigrationJob extends BaseJobs {

    public $building_name;
    public $road_name;
    public $area_name;
    public $city_name;
    public $state_name;
    public $building_id;
    public $road_id;
    public $area_id;
    public $city_id;
    public $state_id;

    public function scenarios() {
        return [
            Location::SCENARIO_CREATE => ["building_id", "area_id", "road_id", "city_id", "state_id"],
            Location::SCENARIO_MIGRATE => ["building_name", "area_name", "road_name", "city_name", "state_name"],
        ];
    }

    public function rules() {
        return [
            [["building_name", "area_name", "road_name", "city_name", "state_name"], "required"],
            [["building_name", "area_name", "road_name", "city_name", "state_name"], "string"],
            ["state_name", function ($attribute, $params, $validator) {
                    $model = Location::find()->where(['or', ['name' => $this->state_name], ['code' => $this->state_name]])
                                    ->andWhere(['type' => C::LOCATION_STATE])->one();
                    if ($model instanceof Location) {
                        $this->state_id = $model->id;
                    } else {
                        $this->addError($attribute, "Invalid State Code");
                    }
                }],
        ];
    }

    public function save() {
        if (!$this->hasErrors()) {
            $this->city_id = $this->genCity();
            if (!empty($this->city_id)) {
                $this->area_id = $this->genArea();
                if (!empty($this->area_id)) {
                    $this->road_id = $this->genRoad();
                    if (!empty($this->road_id)) {
                        $this->building_id = $this->genBuilding();
                        if (!empty($this->building_id)) {
                            $this->successCnt++;
                            $this->response[$this->count]['message'] = "Ok";
                        }
                    }
                }
            }
        }
        return false;
    }

    public function genBuilding() {
        $model = Location::find()->where(['OR', ['name' => $this->building_name], ['code' => $this->building_name]])
                        ->andWhere(['type' => C::LOCATION_BUILDING])->one();
        if (!$model instanceof Location) {
            $model = new Location(['scenario' => Location::SCENARIO_CREATE]);
            $model->name = $this->building_name;
            $model->type = C::LOCATION_BUILDING;
            $model->state_id = $this->state_id;
            $model->city_id = $this->city_id;
            $model->area_id = $this->area_id;
            $model->road_id = $this->road_id;
            $model->status = C::STATUS_ACTIVE;
            if ($model->validate() && $model->save()) {
                return $model->id;
            } else {
                $this->errorCnt++;
                $this->response[$this->count]["message"] = implode(" ", $model->getErrorSummary(true));
            }
        } else {
            return $model->id;
        }
        return false;
    }

    public function genRoad() {
        $model = Location::find()->where(['OR', ['name' => $this->road_name], ['code' => $this->road_name]])
                        ->andWhere(['type' => C::LOCATION_ROAD])->one();
        if (!$model instanceof Location) {
            $model = new Location(['scenario' => Location::SCENARIO_CREATE]);
            $model->name = $this->road_name;
            $model->type = C::LOCATION_ROAD;
            $model->state_id = $this->state_id;
            $model->city_id = $this->city_id;
            $model->area_id = $this->area_id;
            $model->status = C::STATUS_ACTIVE;
            if ($model->validate() && $model->save()) {
                return $model->id;
            } else {
                $this->errorCnt++;
                $this->response[$this->count]["message"] = implode(" ", $model->getErrorSummary(true));
            }
        } else {
            return $model->id;
        }
        return false;
    }

    public function genArea() {
        $model = Location::find()->where(['OR', ['name' => $this->area_name], ['code' => $this->area_name]])
                        ->andWhere(['type' => C::LOCATION_AREA])->one();
        if (!$model instanceof Location) {
            $model = new Location(['scenario' => Location::SCENARIO_CREATE]);
            $model->name = $this->area_name;
            $model->type = C::LOCATION_AREA;
            $model->state_id = $this->state_id;
            $model->city_id = $this->city_id;
            $model->status = C::STATUS_ACTIVE;
            if ($model->validate() && $model->save()) {
                return $model->id;
            } else {
                $this->errorCnt++;
                $this->response[$this->count]["message"] = implode(" ", $model->getErrorSummary(true));
            }
        } else {
            return $model->id;
        }
        return false;
    }

    public function genCity() {
        $model = Location::find()->where(['OR', ['name' => $this->city_name], ['code' => $this->city_name]])
                        ->andWhere(['type' => C::LOCATION_CITY])->one();
        if (!$model instanceof Location) {
            $model = new Location(['scenario' => Location::SCENARIO_CREATE]);
            $model->name = $this->city_name;
            $model->type = C::LOCATION_CITY;
            $model->state_id = $this->state_id;
            $model->status = C::STATUS_ACTIVE;
            if ($model->validate() && $model->save()) {
                return $model->id;
            } else {
                $this->errorCnt++;
                $this->response[$this->count]["message"] = implode(" ", $model->getErrorSummary(true));
            }
        } else {
            return $model->id;
        }
        return false;
    }

    public function _execute($data) {
        $this->scenario = Operator::SCENARIO_MIGRATE;
        if ($this->load($data, '') && $this->validate() && $this->save()) {
            return true;
        } else {
            if (!empty($this->errors)) {
                $this->errorCnt++;
                $this->response[$this->count]["message"] = implode(" ", $this->getErrorSummary(true));
            }
        }
    }

}
