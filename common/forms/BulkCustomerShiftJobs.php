<?php

namespace common\forms;

use common\models\Operator;
use common\models\Location;
use common\ebl\Constants as C;
use common\models\CustomerAccount;

class BulkCustomerShiftJobs extends \common\ebl\jobs\BaseFormJobs {

    public $account_ids;
    public $operator_id;
    public $road_id;
    public $building_id;
    public $operator;
    public $building;
    public $road;
    public $job_id;

    public function rules(): array {
        return [
            [["account_ids", "building_id"], 'required'],
            [["operator_id", "road_id"], 'integer'],
            ['account_ids', 'each', 'rule' => ['integer']],
            [['operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['operator_id' => 'id']],
            [['building_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['building_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            "building_id" => "Building",
            "operator_id" => "Franchise",
            "account-ids" => "Accounts"
        ];
    }

    public function beforeValidate() {
        $loc = Location::findOne(['id' => $this->building_id, 'type' => C::LOCATION_BUILDING]);
        if ($loc instanceof Location) {
            $this->road_id = $loc->road_id;
            $this->building_id = $loc->id;
            $this->building = $loc;
            $this->road = $loc->road;
        }

        $opt = Operator::findOne(['id' => $this->operator_id, 'type' => C::USERTYPE_OPERATOR]);

        if ($opt instanceof Operator) {
            $this->operator = $opt;
        }
        return parent::beforeValidate();
    }

    public function save() {
        if (!$this->hasErrors()) {
            $migrateData = [];
            $query = new \yii\db\Query();
            $query->andWhere(['not in', 'operator_id', $this->operator_id])->andWhere(['id' => $this->account_ids]);
            $accountObj = CustomerAccount::find()->andWhere($query->where);
            $this->total_record = $accountObj->count();

            if ($this->total_record == 0) {
                $this->response['message'] = "Not Account found for shifting.";
            }

            foreach ($accountObj->batch() as $accounts) {
                foreach ($accounts as $account) {
                    $migrateData = [
                        'account_id' => $account->id,
                        'customer_id' => $account->customer_id,
                        "cid" => $account->cid,
                        "name" => $account->customer->name,
                        "username" => $account->username,
                        'from_operator_id' => $account->operator_id,
                        'to_operator_id' => $this->operator_id,
                        'from_operator' => $account->operator->name,
                        "from_operator_code" => $account->operator->code,
                        "to_operator" => $this->operator->name,
                        "to_operator_code" => $this->operator->code,
                        'from_road_id' => $account->road_id,
                        'to_road_id' => $this->road_id,
                        'from_road' => $account->road->name,
                        'to_road' => $this->road->name,
                        'from_building_id' => $account->building_id,
                        'to_building_id' => $this->building_id,
                        'from_building' => $account->building->name,
                        'to_building' => $this->building->name,
                    ];
                    $this->response[$this->count] = $migrateData;
                    $account->scenario = CustomerAccount::SCENARIO_UPDATE;
                    $account->road_id = $this->road_id;
                    $account->building_id = $this->building_id;
                    $account->operator_id = $this->operator_id;
                    if ($account->validate() && $account->save()) {
                        $this->insertMigrateData($migrateData);
                        $this->successCnt++;
                        $this->response[$this->count]['remark'] = "User {$account->username} shifted to franchise {$this->operator->name}.";
                        $this->response[$this->count]['message'] = "Ok";
                    } else {
                        $this->errorCnt++;
                        $this->response[$this->count]["message"] = implode(" ", $account->getErrorSummary(true));
                    }
                    $this->count++;
                }
            }
        }

        return false;
    }

    public function insertMigrateData($data) {
        $model = new \common\models\SubscriberShiftingLog();
        $model->scenario = \common\models\SubscriberShiftingLog::SCENARIO_CREATE;
        $model->load($data, '');
        if ($model->validate() && $model->save()) {
            return true;
        }
        return false;
    }

    public function scheduleBulk() {
        $class = self::class;
        $data = ["account_ids" => $this->account_ids, 'building_id' => $this->building_id, 'operator_id' => $this->operator_id];
        $this->_scheduleBulk($class, $data);
        return $this->_scheduleBulk($class, $data);
    }

    public function _execute() {
        if ($this->validate()) {
            return $this->save();
        } else {
            return $this->errors;
        }
    }

}
