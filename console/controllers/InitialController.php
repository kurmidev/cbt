<?php

namespace console\controllers;

use Yii;
use common\models\Designation;
use common\models\User;
use common\models\Operator;
use common\ebl\Constants;
use common\models\Location;
use common\models\TaxMaster;

class InitialController extends BaseConsoleController {

    public function actionInit() {
        $this->addState();
        $this->addRules();
        $this->addDefaultDesignation();
        $this->addTax();
        $this->addRouter();
    }

    private function addState() {
        $states = ['Andhra Pradesh', 'New Delhi', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand', 'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'];
        $i = 0;
        foreach ($states as $state) {
            $m = Location::findOne(['name' => $state]);
            if ($m instanceof Location) {
                continue;
            }
            $model = new \common\models\Location(['scenario' => \common\models\Location::SCENARIO_CREATE]);
            $model->name = $state;
            $model->status = \common\ebl\Constants::STATUS_ACTIVE;
            $model->type = \common\ebl\Constants::LOCATION_STATE;
            $model->state_id = 0;
            $model->city_id = 0;
            $model->area_id = 0;
            $model->road_id = 0;
            if ($model->validate() && $model->save()) {
                $i++;
                echo "creating $state from $i/" . count($states) . PHP_EOL;
            }
        }
    }

    private function getState($state) {
        $s = Location::find()->where(['or', ['name' => $state], ['code' => $state], ['id' => $state]])
                        ->andWhere(['type' => Constants::LOCATION_STATE])->one();

        if (!$s instanceof Location) {
            $s = \yii\helpers\ArrayHelper::map(Location::find()->where(['type' => Constants::LOCATION_STATE])
                                    ->asArray()->all(), 'id', function ($e) {
                                return $e['name'] . "(" . $e['code'] . ")";
                            });
            if (!empty($s)) {
                $this->stdout("List ofthe States" . PHP_EOL, \yii\helpers\Console::BOLD, \yii\helpers\Console::BG_YELLOW);
                foreach ($s as $id => $name) {
                    $this->stdout($this->ansiFormat("$id. $name" . PHP_EOL, \yii\helpers\Console::BOLD));
                }
            }
            $state = $this->prompt("Enter State id ", ['required' => TRUE]);
            return $this->getState($state);
        } else {
            return $s;
        }
    }

    private function addCity($state = null, $city) {
        $s = $this->getState($state);
        if ($s instanceof Location) {
            $c = Location::find()->where(['or', ['name' => $city], ['code' => $city]])
                            ->andWhere(['type' => Constants::LOCATION_CITY])->one();

            if ($c instanceof Location) {
                return [$c->state_id, $c->id];
            } else {
                $c = new Location();
                $c->scenario = Location::SCENARIO_CREATE;
                $c->name = $city;
                $c->state_id = $s->id;
                $c->city_id = $c->area_id = $c->road_id = 0;
                $c->status = Constants::STATUS_ACTIVE;
                $c->type = Constants::LOCATION_CITY;
                if ($c->validate() && $c->save()) {
                    return [$c->state_id, $c->id];
                } else {
                    throw new \Exception("City creations failed!");
                }
            }
        }
    }

    public function addRules() {
        $menus = \backend\component\MenuHelper::$menu;

        $auth = \Yii::$app->authManager;
        $auth->removeAll();
        $auth->removeAllAssignments();
        foreach ($menus as $menu) {
            if (!empty($menu['items'])) {
                foreach ($menu['items'] as $items) {
                    foreach ($items as $item) {
                        if (!empty($item['controller']) && !empty($item['action'])) {
                            $name = $item['controller'] . "-" . $item['action'];
                            $cp = $auth->createPermission($name);
                            $cp->description = $item['label'];
                            echo $item['label'] . "----$name permission created" . PHP_EOL;
                            $auth->add($cp);
                            unset($cp);
                        }
                    }
                }
            }
        }
    }

    public function addDefaultDesignation() {
        $desig = [Constants::DESIG_MSO => "MSO", Constants::DESIG_RO => "RO", Constants::DESIG_DISTRIBUTOR => "Distributor", Constants::DESIG_OPERATOR => Constants::OPERATOR_TYPE_LCO_NAME];

        foreach ($desig as $ds => $dn) {
            $d = Designation::findOne(['id' => $ds]);
            if (!$d instanceof Designation) {
                $d = new Designation();
                $d->scenario = Designation::SCENARIO_CREATE;
                $d->name = $dn;
                $d->parent_id = 0;
                $d->status = \common\ebl\Constants::STATUS_ACTIVE;
                if ($d->validate() && $d->save()) {
                    Designation::updateAll(['id' => $ds], ['id' => $d->id]);
                    $role = [];
                    if ($ds > 0) {
                        $role = [$ds];
                    }
                    \common\ebl\AuthUser::addDesignationAuthRule($d->name, [], $role);
                    echo "Designation {$d->name} created...." . PHP_EOL;
                }
            }
        }
    }

    public function actionCreateMso($name, $username, $password, $mobile_no, $city, $state = null) {
        list($state_id, $city_id) = $this->addCity($state, $city);
        $isMsoExist = Operator::find()->where(['type' => Constants::OPERATOR_TYPE_MSO])->count();
        if ($isMsoExist > 0) {
            exit('MSO Already exist only one is allowed');
        }

        $op = Operator::findOne(['name' => $name]);
        $usr = User::findOne(['username' => $username]);

        if ((!$op instanceof Operator) && (!$usr instanceof common\models\User)) {
            $operator = new Operator(['scenario' => Operator::SCENARIO_CREATE]);
            $operator->name = $name;
            $operator->contact_person = $name;
            $operator->mobile_no = $mobile_no;
            $operator->address = "MSO Address";
            $operator->type = Constants::OPERATOR_TYPE_MSO;
            $operator->mso_id = $operator->distributor_id = 0;
            $operator->city_id = $city_id;
            $operator->state_id = $state_id;
            $operator->billing_by = 0;
            $operator->username = $username;
            if ($operator->validate() && $operator->save()) {
                $this->createUser($operator, $password);
            } else {
                var_dump($operator->errors);
            }
        } else {
            echo ($op instanceof Operator) ? "Operator with name $name already exists" . PHP_EOL : "";
            echo ($usr instanceof common\models\User) ? "user with username $username already exists" . PHP_EOL : "";
        }
    }

    private function createUser(Operator $o, $password) {
        $d = Designation::findOne(['id' => Constants::DESIG_MSO]);
        if (!$d instanceof Designation) {
            $d = new Designation();
            $d->scenario = Designation::SCENARIO_CREATE;
            $d->name = "MSO";
            $d->parent_id = 0;
            $d->status = \common\ebl\Constants::STATUS_ACTIVE;
            if ($d->validate() && $d->save()) {
                Designation::updateAll(['id' => Constants::DESIG_MSO], ['id' => $d->id]);
                \common\ebl\AuthUser::addDesignationAuthRule($d->name);
                echo "Designation {$d->name} created...." . PHP_EOL;
            }
        }

        $cnt = User::find()->where(['user_type' => Constants::USERTYPE_MSO])->count();
        if ($cnt == 0) {
            $u = new User();
            $u->name = $o->name;
            $u->mobile_no = $o->mobile_no;
            $u->user_type = \common\ebl\Constants::USERTYPE_MSO;
            $u->email = $o->email;
            $u->reference_id = $o->id;
            $u->designation_id = $d->id;
            $u->username = $o->username;
            $u->password = md5($password);
            $u->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
            $u->auth_key = Yii::$app->security->generateRandomString();
            $u->password_reset_token = Yii::$app->security->generateRandomString();
            $u->status = \common\ebl\Constants::STATUS_ACTIVE;
            if ($u->validate() && $u->save()) {
                echo "MSO creadentials created......." . PHP_EOL;
            }
        }
    }

    public function addTax() {
        $model = new TaxMaster(['scenario' => TaxMaster::SCENARIO_CREATE]);
        $model->name = $model->code = "CGST";
        $model->value = 9;
        $model->type = Constants::TAX_PERCENTAGE;
        $model->applicable_on = [Constants::TAX_APPLICABLE_PLAN, Constants::TAX_APPLICABLE_DEVICE];
        $model->status = Constants::STATUS_ACTIVE;
        if ($model->validate()) {
            $model->save();
        }

        $model = new TaxMaster(['scenario' => TaxMaster::SCENARIO_CREATE]);
        $model->name = $model->code = "SGST";
        $model->value = 9;
        $model->type = Constants::TAX_PERCENTAGE;
        $model->applicable_on = [Constants::TAX_APPLICABLE_PLAN, Constants::TAX_APPLICABLE_DEVICE];
        $model->status = Constants::STATUS_ACTIVE;
        if ($model->validate()) {
            $model->save();
        }
        $model = new TaxMaster(['scenario' => TaxMaster::SCENARIO_CREATE]);
        $model->name = $model->code = "AGR";
        $model->value = 8;
        $model->type = Constants::TAX_PERCENTAGE;
        $model->applicable_on = [Constants::TAX_APPLICABLE_PLAN];
        $model->status = Constants::STATUS_ACTIVE;
        if ($model->validate()) {
            $model->save();
        }
    }

    public function addRouter() {
        $arrays = [
            ['code' => 'ROUTER_MIKROTIK', 'name' => 'Mikrotik', 'status' => 1, 'attrbs' => [
                    ["name" => "Cleartext-Password", "op" => ":=", "group" => "check"],
                    ["name" => "Calling-Station-Id", "op" => ":=", "group" => "check"],
                    ["name" => "Expiration", "op" => ":=", "group" => "check"],
                    ["name" => "NAS-IP-Address", "op" => ":=", "group" => "check"],
                    ["name" => "Simultaneous-Use", "op" => ":=", "group" => "check"],
                    ["name" => "Login-Time", "op" => ":=", "group" => "check"],
                ]],
            ['code' => 'ROUTER_JUNIPER', 'name' => 'Juniper', 'status' => 1, 'attrbs' => []],
            ['code' => 'ROUTER_HUAWEI', 'name' => 'Huawei', 'status' => 1, 'attrbs' => []],
        ];

        foreach ($arrays as $array) {
            $model = new \common\models\RouterMaster();
            $model->load($array, '');
            if ($model->validate() && $model->save()) {
                echo "Router {$model->code} added successfully..." . PHP_EOL;
            } else {
                print_r($model->errors);
            }
        }
    }

}
