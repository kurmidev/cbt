<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CustomerAccount;
use common\ebl\Constants;
use common\component\Utils as U;
use yii\helpers\ArrayHelper;

/**
 * CustomerAccountSearch represents the model behind the search form of `common\models\CustomerAccount`.
 */
class CustomerAccountSearch extends CustomerAccount {

    public $username_start;
    public $customer_name;
    public $mobile_no;
    public $distributor_id;
    public $plan_id;
    public $email;
    public $added_on_start;
    public $added_on_end;
    public $start_date_start;
    public $start_date_end;
    public $end_date_start;
    public $end_date_end;
    public $curr;
    public $last7Days;
    public $next7Days;
    public $todays;
    public $thisMonth;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'customer_id', 'operator_id', 'road_id', 'router_type', 'status', 'account_types', 'is_auto_renew', 'prospect_id', 'added_by', 'updated_by'], 'integer'],
            [['cid', 'username', 'password', 'building_id', 'mac_address', 'static_ip', 'start_date', 'end_date', 'meta_data', 'current_plan', 'added_on', 'updated_on', 'username_start', 'customer_name', "plan_id", "mobile_no", "email", "added_on_start", "added_on_end", "distributor_id", 'curr', "last7Days", "todays", "thisMonth", "next7Days", "plan_id", "start_date_start", "start_date_end", "end_date_start", "end_date_end"], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
// bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = CustomerAccount::find();

// add conditions that should always apply here

        $dataProvider = new \common\component\ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
// uncomment the following line if you do not want to return any records when validation fails
// $query->where('0=1');
            return $dataProvider;
        }

        $query->defaultCondition($query->talias);
// grid filtering conditions
        $query->andFilterWhere([
            $query->talias . 'id' => $this->id,
            $query->talias . 'customer_id' => $this->customer_id,
            $query->talias . 'operator_id' => $this->operator_id,
            $query->talias . 'road_id' => $this->road_id,
            $query->talias . 'router_type' => $this->router_type,
            $query->talias . 'start_date' => $this->start_date,
            $query->talias . 'end_date' => $this->end_date,
            $query->talias . 'status' => $this->status,
            $query->talias . 'account_types' => $this->account_types,
            $query->talias . 'is_auto_renew' => $this->is_auto_renew,
            $query->talias . 'prospect_id' => $this->prospect_id,
            $query->talias . 'added_on' => $this->added_on,
            $query->talias . 'updated_on' => $this->updated_on,
            $query->talias . 'added_by' => $this->added_by,
            $query->talias . 'updated_by' => $this->updated_by,
        ]);

        if (!empty($this->username_start)) {
            $query->andFilterWhere(['like', $query->talias . 'username', "$this->username_start%", false]);
        }

        if (!empty($this->curr)) {
            $query->andWhere(['<', $query->talias . 'start_date', date("Y-m-d 00:00:00")])
                    ->andWhere(['>', $query->talias . 'end_date', date("Y-m-d 23:59:00")]);
        }


        if (!empty($this->customer_name) || !empty($this->mobile_no) || !empty($this->email)) {
            $query->joinWith(['customer s'])->andFilterWhere(['like', 's.name', $this->customer_name])
                    ->andFilterWhere(['like', 's.mobile_no', $this->mobile_no])
                    ->andFilterWhere(['like', 's.email', $this->email]);
        }

        if (!empty($this->distributor_id)) {
            $query->joinWith(['operator o'])->andFilterWhere(['o.distributor_id' => $this->distributor_id]);
        }

        if (!empty($this->added_on_start) && !empty($this->added_on_end)) {
            $query->andWhere(['between', $query->talias . 'added_on', $this->added_on_start, U::getEndDate($this->added_on_end)]);
        }

        if (isset($this->next7Days)) {
            $query->andWhere(['between', $query->talias . 'end_date', date("Y-m-d", strtotime("+1days")), date("Y-m-d", strtotime("+7day"))]);
        }

        if (isset($this->last7Days)) {
            $query->andWhere(['between', $query->talias . 'added_on', date("Y-m-d 00:00:00", strtotime("-8days")), date("Y-m-d 00:00:00", strtotime("-1day"))]);
        }

        if (isset($this->todays)) {
            $query->andWhere(['between', $query->talias . 'added_on', date("Y-m-d 00:00:00"), date("Y-m-d 23:59:00")]);
        }

        if (isset($this->thisMonth)) {
            $query->andWhere(['between', $query->talias . 'added_on', date("Y-m-01 00:00:00"), date("Y-m-t 00:00:00")]);
        }

        if (!empty($this->plan_id)) {
            $query->joinWith(['activePlans p'])->andWhere(['p.plan_id' => $this->plan_id]);
        }

        $query->andFilterWhere(['like', $query->talias . 'cid', $this->cid])
                ->andFilterWhere(['like', $query->talias . 'username', $this->username])
                ->andFilterWhere(['like', $query->talias . 'password', $this->password])
                ->andFilterWhere(['like', $query->talias . 'building_id', $this->building_id])
                ->andFilterWhere(['like', $query->talias . 'mac_address', $this->mac_address])
                ->andFilterWhere(['like', $query->talias . 'static_ip', $this->static_ip])
                ->andFilterWhere(['like', $query->talias . 'meta_data', $this->meta_data])
                ->andFilterWhere(['like', $query->talias . 'current_plan', $this->current_plan]);

        return $dataProvider;
    }

    public function displayColumn($type = "", $text = "") {
        $return = [];
        switch ($type) {
            case "optcnt":
                $return = [
                    ['class' => 'yii\grid\SerialColumn'],
                    'operator.name:text:Franchise',
                    'operator.code:text:Franchise Code',
                    'operator.distributor.name:text:Distributor',
                    'operator.distributor.code:text:Distributor Code',
                    [
                        "label" => "Active",
                        "content" => function ($model) {
                            return \yii\helpers\Html::a($model->active, \Yii::$app->urlManager->createUrl(['report/active-customer', "CustomerAccountSearch[operator_id]" => $model->operator_id, "CustomerAccountSearch[curr]" => 1]), ["target" => "_blank"]);
                        }
                    ],
                    [
                        "label" => "In-Active",
                        "content" => function ($model) {
                            return \yii\helpers\Html::a($model->inactive, \Yii::$app->urlManager->createUrl(['report/inactive-customer', "CustomerAccountSearch[operator_id]" => $model->operator_id]), ["target" => "_blank"]);
                        }
                    ],
                    [
                        "label" => "Expired",
                        "content" => function ($model) {
                            return \yii\helpers\Html::a($model->expired, \Yii::$app->urlManager->createUrl(['report/expired-customer', "CustomerAccountSearch[operator_id]" => $model->operator_id]), ["target" => "_blank"]);
                        }
                    ]
                ];
                break;
            default :
                $return = [
                    ['class' => 'yii\grid\SerialColumn'],
                    'cid:text:Customer Id',
                    'customer.name:text:Name',
                    'username',
                    'customer.mobile_no:text:Mobile No',
                    'customer.email:email:Email',
                    ['attribute' => 'customer.connection_type', 'label' => 'Conn Type',
                        'content' => function ($model) {
                            return !empty($model->customer) ?
                            U::getLabels(Constants::LABEL_CONNECTION_TYPE, $model->customer->connection_type) : "";
                        },
                        'filter' => Constants::LABEL_CONNECTION_TYPE,
                    ],
                    "operator.name:text:Franchise",
                    "operator.code:text:Franchise Code",
                    "operator.distributor.name:text:Distributor",
                    "operator.distributor.code:text:Distributor Code",
                    [
                        "label" => "Current Plan",
                        "content" => function ($model) {
                            if (!empty($model->currentPlans)) {
                                $p = \yii\helpers\ArrayHelper::getColumn($model->currentPlans, "plan.name");
                                if (!empty($p)) {
                                    return implode(",", $p);
                                }
                            }
                            return "";
                        }
                    ],
                    'start_date:date:Start Date',
                    'end_date:date:End Date',
                    ['attribute' => 'status', 'label' => 'Status',
                        'content' => function ($model) {
                            return U::getStatusLabel($model->status);
                        },
                        'filter' => Constants::LABEL_STATUS,
                    ],
                    'actionOn',
                    'actionBy',
                ];
                break;
        }

        if ($type == "renew") {
            $return[] = [
                'class' => 'yii\grid\CheckboxColumn',
                "name" => $text . "[account_ids]",
                'checkboxOptions' => function ($model, $key, $index, $widget) {
                    return ["value" => $model->id];
                }];
        }
        return $return;
    }

    public function advanceSearch($type = "") {
        switch ($type) {
            case "optcnt":
                return [
                    ["label" => "Franchise", "attribute" => "operator_id", "type" => "dropdown", "list" => ArrayHelper::map(Operator::find()->defaultCondition()->andWhere(['type' => Constants::OPERATOR_TYPE_LCO])->asArray()->all(), "id", "name")],
                    ["label" => "Distributor", "attribute" => "distributor_id", "type" => "dropdown", "list" => ArrayHelper::map(Operator::find()->defaultCondition()->andWhere(['type' => Constants::OPERATOR_TYPE_DISTRIBUTOR])->asArray()->all(), "id", "name")],
                ];
            default:
                return [
                    ["label" => "Name", "attribute" => "customer_name", "type" => "text"],
                    ["label" => "username", "attribute" => "username", "type" => "text"],
                    ["label" => "Mobile No", "attribute" => "mobile_no", "type" => "text"],
                    ["label" => "Franchise", "attribute" => "operator_id", "type" => "dropdown", "list" => ArrayHelper::map(Operator::find()->defaultCondition()->andWhere(['type' => Constants::OPERATOR_TYPE_LCO])->asArray()->all(), "id", "name")],
                    ["label" => "Distributor", "attribute" => "distributor_id", "type" => "dropdown", "list" => ArrayHelper::map(Operator::find()->defaultCondition()->andWhere(['type' => Constants::OPERATOR_TYPE_DISTRIBUTOR])->asArray()->all(), "id", "name")],
                    ["label" => "Status", "attribute" => "status", "type" => "dropdown", "list" => Constants::LABEL_SUBSCRIBER_STATUS],
                    ["label" => "Account Type", "attribute" => "account_types", "type" => "dropdown", "list" => Constants::LABEL_ACCOUNT_TYPE],
                    ["label" => "Plan", "attribute" => "plan_id", "type" => "dropdown", "list" => ArrayHelper::map(PlanMaster::find()->defaultCondition()->active()->asArray()->all(), 'id', 'name')],
                    ["label" => "Added On", "attribute" => "added_on", "type" => "date_range"],
                    ["label" => "Start Date", "attribute" => "start_date", "type" => "date_range"],
                    ["label" => "End Date", "attribute" => "end_date", "type" => "date_range"],
                ];
        }
    }

}
