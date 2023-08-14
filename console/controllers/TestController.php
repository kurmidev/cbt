<?php

namespace console\controllers;

use Yii;

//281248
//Saanvi@2019

class TestController extends BaseConsoleController {

    public function actionDateTest($startTime, $endTime) {
        echo \common\component\Utils::getTotalHrs($startTime, $endTime);
        echo PHP_EOL;
    }

    public function actionRateCal() {
        $conf = [
            'assoc_id' => 1,
            'operator_id' => 3,
            'type' => \common\ebl\Constants::RATE_TYPE_PLAN,
            'rate_id' => 2
        ];
        $m = new \common\ebl\RateCalculation($conf);
        print_R($m->calculateRates);
    }

    public function actionLogin($account_id) {
        $model = \common\models\Account::findOne($account_id);
        if ($model instanceof \common\models\Account) {
            $model->generateLogins();
        }
    }

    public function actionTestBalance($id) {
        $model = \common\models\Operator::findOne(['id' => $id]);
        if ($model instanceof \common\models\Operator) {
            print_r($model->balance);
        }
    }

    public function actionAuth() {
        $item = \common\ebl\AuthUser::itemsList([\common\ebl\Constants::USERTYPE_OPERATOR]);
        print_r($item);
    }

    public function actionJobs($id) {

//        $job = \common\models\ScheduleJobLogs::findOne(["_id" => (int) $id]);
//        if ($job instanceof \common\models\ScheduleJobLogs) {
//            $job->scheduleJob();
//            echo "job schedulef successfully.";
//        }
        //$j = new \common\ebl\jobs\FinalReconsilationJob(['sjl_id' => $id]);
//        $j = new \common\forms\AssignPolicyForm(['sjl_id' => $id]);
//        $j->execute([]);

        $job = \common\models\ScheduleJobLogs::findOne(["_id" => (int) $id]);
        if (!empty($job)) {
            $data = \yii\helpers\ArrayHelper::merge($job->model_data, ['sjl_id' => $job->_id]);
            $obj = new $job->model($data);

            $obj->execute([]);
        }
    }

    public function actionCheckPayment($order_id) {
        $model = \common\models\OnlinePayments::findOne(['order_id' => $order_id]);
        if ($model instanceof \common\models\OnlinePayments) {
            $model->processPayments();
        }
    }

    public function actionLoadAsset() {
        $plans = \common\models\PlanMaster::find()->asArray()->all();
        print_r(count($plans));
        foreach ($plans as $plan) {
            $model = \common\models\BouquetAssets::findOne(['mapped_id' => $plan['id'], 'type' => \common\ebl\Constants::BOUQUET_ASSET_INTERNET]);
            if (!$model instanceof \common\models\BouquetAssets) {
                $model = new \common\models\BouquetAssets(['scenario' => \common\models\BouquetAssets::SCENARIO_CREATE]);
            } else {
                $model->scenario = \common\models\BouquetAssets::SCENARIO_UPDATE;
            }
            $model->name = $plan['name'];
            $model->code = $plan['code'];
            $model->type = \common\ebl\Constants::BOUQUET_ASSET_INTERNET;
            $model->price = 0;
            $model->status = $plan['status'];
            $model->mapped_id = $plan['id'];
            if ($model->validate() && $model->save()) {
                echo "Plan {$model->name}\r\n" . PHP_EOL;
            } else {
                print_r($model->errors);
            }
        }
    }

    public function actionPopulateOtt() {
        $validDays = [30, 60, 90, 180, 365];
        for ($i = 0; $i < 100; $i++) {
            $faker = \Faker\Factory::create();
            $model = new \common\models\OttMaster(['scenario' => \common\models\OttMaster::SCENARIO_CREATE]);
            $model->name = $faker->name;
            $model->code = $faker->word;
            $model->validity = $validDays[array_rand($validDays, 1)];
            $model->description = $faker->paragraph;
            $model->status = \common\ebl\Constants::STATUS_ACTIVE;
            if ($model->validate() && $model->save()) {
                echo "{($i+1)} : OTT Added with name {$model->name}" . PHP_EOL;
            } else {
                print_r($model->errors);
            }
        }
    }

    public function actionCheck() {
        $model = new \m200504_120250_create_ip_pool_list_table();
        $model->down();
        $model->up();
    }

}
