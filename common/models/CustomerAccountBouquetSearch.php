<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CustomerAccountBouquet;
use common\ebl\Constants as C;
use common\component\Utils as U;
use yii\helpers\ArrayHelper;

/**
 * CustomerAccountBouquetSearch represents the model behind the search form of `common\models\CustomerAccountBouquet`.
 */
class CustomerAccountBouquetSearch extends CustomerAccountBouquet {

    public $customer_name;
    public $distributor_id;
    public $added_on_start;
    public $added_on_end;
    public $username;
    public $current;
    public $todaysRenewals;
    public $last7DaysRenewals;
    public $thisMonthRenewals;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'account_id', 'customer_id', 'operator_id', 'road_id', 'router_type', 'status', 'bouquet_id', 'bouquet_type', 'is_refundable', 'rate_id', 'renewal_type', 'added_by', 'updated_by'], 'integer'],
            [['building_id', 'start_date', 'end_date', 'cal_end_date', 'meta_data', 'upload', 'download', 'remark', 'added_on', 'updated_on', 'history', "customer_name", "distributor_id", "added_on_start", "added_on_end", "username", "current", "todaysRenewals", "last7DaysRenewals", "thisMonthRenewals"], 'safe'],
            [['per_day_amount', 'per_day_mrp', 'amount', 'tax', 'mrp', 'mrp_tax', 'refund_amount', 'refund_tax', 'refund_mrp', 'refund_mrp_tax'], 'number'],
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
        $query = CustomerAccountBouquet::find();

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

        if (!empty($this->customer_name)) {
            $query->joinWith(['customer s'])->andFilterWhere(['like', 's.name', $this->customer_name]);
        }

        if (!empty($this->username)) {
            $query->joinWith(['account ac'])->andFilterWhere(['like', 'ac.username', $this->username]);
        }

        if (!empty($this->distributor_id)) {
            $query->joinWith(['operator o'])->andFilterWhere(['o.distributor_id' => $this->distributor_id]);
        }

        if (!empty($this->added_on_start) && !empty($this->added_on_end)) {
            $query->andWhere(['between', $query->talias . 'added_on', $this->added_on_start, U::getEndDate($this->added_on_end)]);
        }

        if (!empty($this->current)) {
            $query->andWhere(['<', $query->talias . 'start_date', date("Y-m-d 00:00:00")])
                    ->andWhere(['>', $query->talias . 'end_date', date("Y-m-d 23:59:00")]);
        }

        if (isset($this->last7DaysRenewals)) {
            $query->andWhere(['between', $query->talias . 'added_on', date("Y-m-d 00:00:00", strtotime("-8days")), date("Y-m-d 00:00:00", strtotime("-1day"))]);
        }

        if (isset($this->todaysRenewals)) {
            $query->andWhere(['between', $query->talias . 'added_on', date("Y-m-d 00:00:00"), date("Y-m-d 23:59:00")]);
        }

        if (isset($this->thisMonthRenewals)) {
            $query->andWhere(['between', $query->talias . 'added_on', date("Y-m-01 00:00:00"), date("Y-m-t 00:00:00")]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            $query->talias . 'id' => $this->id,
            $query->talias . 'account_id' => $this->account_id,
            $query->talias . 'customer_id' => $this->customer_id,
            $query->talias . 'operator_id' => $this->operator_id,
            $query->talias . 'road_id' => $this->road_id,
            $query->talias . 'router_type' => $this->router_type,
            $query->talias . 'start_date' => $this->start_date,
            $query->talias . 'end_date' => $this->end_date,
            $query->talias . 'cal_end_date' => $this->cal_end_date,
            $query->talias . 'status' => $this->status,
            $query->talias . 'bouquet_id' => $this->bouquet_id,
            $query->talias . 'bouquet_type' => $this->bouquet_type,
            $query->talias . 'is_refundable' => $this->is_refundable,
            $query->talias . 'rate_id' => $this->rate_id,
            $query->talias . 'per_day_amount' => $this->per_day_amount,
            $query->talias . 'per_day_mrp' => $this->per_day_mrp,
            $query->talias . 'amount' => $this->amount,
            $query->talias . 'tax' => $this->tax,
            $query->talias . 'mrp' => $this->mrp,
            $query->talias . 'mrp_tax' => $this->mrp_tax,
            $query->talias . 'refund_amount' => $this->refund_amount,
            $query->talias . 'refund_tax' => $this->refund_tax,
            $query->talias . 'refund_mrp' => $this->refund_mrp,
            $query->talias . 'refund_mrp_tax' => $this->refund_mrp_tax,
            $query->talias . 'renewal_type' => $this->renewal_type,
            $query->talias . 'added_on' => $this->added_on,
            $query->talias . 'updated_on' => $this->updated_on,
            $query->talias . 'added_by' => $this->added_by,
            $query->talias . 'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'building_id', $this->building_id])
                ->andFilterWhere(['like', 'meta_data', $this->meta_data])
                ->andFilterWhere(['like', 'upload', $this->upload])
                ->andFilterWhere(['like', 'download', $this->download])
                ->andFilterWhere(['like', 'remark', $this->remark])
                ->andFilterWhere(['like', 'history', $this->history]);
        return $dataProvider;
    }

    public function displayColumn($type = "") {
        if ($type == 'plopt') {
            return [
                ['class' => 'yii\grid\SerialColumn'],
                'operator.name:text:Franchise',
                'operator.code:text:Franchise Code',
                'operator.distributor.name:text:Distributor',
                'operator.distributor.code:text:Distributor Code',
                'plan.name:text:Plan',
                'plan.code:text:Plan Code',
                [
                    "attribute" => "bouquet_type",
                    "label" => "Plan Type",
                    "content" => function ($model) {
                        return !empty(C::LABEL_PLAN_TYPE[$model->bouquet_type]) ? C::LABEL_PLAN_TYPE[$model->bouquet_type] : "";
                    }
                ],
                [
                    "label" => "Active",
                    "content" => function ($model) {
                        return \yii\helpers\Html::a($model->active, \Yii::$app->urlManager->createUrl(['report/renewal', "CustomerAccountBouquetSearch[bouquet_id]" => $model->bouquet_id, "CustomerAccountBouquetSearch[status]" => C::STATUS_ACTIVE, 'CustomerAccountBouquetSearch[current]' => 1, "CustomerAccountBouquetSearch[operator_id]" => $model->operator_id]), ["target" => "_blank"]);
                    }
                ],
                [
                    "label" => "In Active",
                    "content" => function ($model) {

                        return \yii\helpers\Html::a($model->inactive, \Yii::$app->urlManager->createUrl(['report/renewal', "CustomerAccountBouquetSearch[bouquet_id]" => $model->bouquet_id, "CustomerAccountBouquetSearch[status]" => C::STATUS_INACTIVE, "CustomerAccountBouquetSearch[operator_id]" => $model->operator_id]), ["target" => "_blank"]);
                    }
                ],
                [
                    "label" => "Expired",
                    "content" => function ($model) {
                        return \yii\helpers\Html::a($model->expiry, \Yii::$app->urlManager->createUrl(['report/renewal', "CustomerAccountBouquetSearch[bouquet_id]" => $model->bouquet_id, "CustomerAccountBouquetSearch[status]" => C::STATUS_EXPIRED, "CustomerAccountBouquetSearch[operator_id]" => $model->operator_id]), ["target" => "_blank"]);
                    }
                ]
            ];
        } else
        if ($type == "plsum") {
            return [
                ['class' => 'yii\grid\SerialColumn'],
                'plan.name',
                'plan.code',
                [
                    "attribute" => "bouquet_type",
                    "label" => "Plan Type",
                    "content" => function ($model) {
                        return !empty(C::LABEL_PLAN_TYPE[$model->bouquet_type]) ? C::LABEL_PLAN_TYPE[$model->bouquet_type] : "";
                    }
                ],
                [
                    "label" => "Active",
                    "content" => function ($model) {
                        return \yii\helpers\Html::a($model->active, \Yii::$app->urlManager->createUrl(['report/renewal', "CustomerAccountBouquetSearch[bouquet_id]" => $model->bouquet_id, "CustomerAccountBouquetSearch[status]" => C::STATUS_ACTIVE, 'CustomerAccountBouquetSearch[current]' => 1, "CustomerAccountBouquetSearch[operator_id]" => $model->operator_id]), ["target" => "_blank"]);
                    }
                ],
                [
                    "label" => "In Active",
                    "content" => function ($model) {
                        return \yii\helpers\Html::a($model->inactive, \Yii::$app->urlManager->createUrl(['report/renewal', "CustomerAccountBouquetSearch[bouquet_id]" => $model->bouquet_id, "CustomerAccountBouquetSearch[status]" => C::STATUS_INACTIVE, "CustomerAccountBouquetSearch[operator_id]" => $model->operator_id]), ["target" => "_blank"]);
                    }
                ],
                [
                    "label" => "Expired",
                    "content" => function ($model) {
                        return \yii\helpers\Html::a($model->expiry, \Yii::$app->urlManager->createUrl(['report/renewal', "CustomerAccountBouquetSearch[bouquet_id]" => $model->bouquet_id, "CustomerAccountBouquetSearch[status]" => C::STATUS_EXPIRED, "CustomerAccountBouquetSearch[operator_id]" => $model->operator_id]), ["target" => "_blank"]);
                    }
                ]
            ];
        } else {
            return [
                ['class' => 'yii\grid\SerialColumn'],
                'customer.name',
                'account.username',
                [
                    "attribute" => "operator_id",
                    "label" => "Franchise",
                    "content" => function ($model) {
                        return !empty($model->operator) ? $model->operator->name : "";
                    }
                ],
                [
                    "label" => "Current Plan",
                    "content" => function ($model) {
                        return !empty($model->plan) ? $model->plan->name : "";
                    }
                ],
                [
                    "label" => "Plan Type",
                    "content" => function ($model) {
                        return !empty(C::LABEL_PLAN_TYPE[$model->bouquet_type]) ? C::LABEL_PLAN_TYPE[$model->bouquet_type] : "";
                    }
                ],
                'start_date',
                'end_date',
                'amount',
                'tax',
                'mrp',
                'mrp_tax',
                ['attribute' => 'status', 'label' => 'Status',
                    'content' => function ($model) {
                        return U::getStatusLabel($model->status);
                    },
                    'filter' => C::LABEL_STATUS,
                ],
                'actionOn',
                'actionBy',
            ];
        }
    }

    public function advanceSearch($type = "") {

        switch ($type) {
            case "plopt":
                return [
                    ["label" => "Franchise", "attribute" => "operator_id", "type" => "dropdown", "list" => ArrayHelper::map(Operator::find()->defaultCondition()->andWhere(['type' => C::OPERATOR_TYPE_LCO])->asArray()->all(), "id", "name")],
                    ["label" => "Distributor", "attribute" => "distributor_id", "type" => "dropdown", "list" => ArrayHelper::map(Operator::find()->defaultCondition()->andWhere(['type' => C::OPERATOR_TYPE_DISTRIBUTOR])->asArray()->all(), "id", "name")],
                    ["label" => "Plan", "attribute" => "bouquet_id", "type" => "dropdown", "list" => ArrayHelper::map(PlanMaster::find()->defaultCondition()->active()->asArray()->all(), 'id', 'name')]
                ];

            case "plsum":
                return [
                    ["label" => "Plan", "attribute" => "bouquet_id", "type" => "dropdown", "list" => ArrayHelper::map(PlanMaster::find()->defaultCondition()->active()->asArray()->all(), 'id', 'name')]
                ];

            default :
                return [
                    ["label" => "Name", "attribute" => "customer_name", "type" => "text"],
                    ["label" => "username", "attribute" => "username", "type" => "text"],
                    ["label" => "Franchise", "attribute" => "operator_id", "type" => "dropdown", "list" => ArrayHelper::map(Operator::find()->defaultCondition()->andWhere(['type' => C::OPERATOR_TYPE_LCO])->asArray()->all(), "id", "name")],
                    ["label" => "Distributor", "attribute" => "distributor_id", "type" => "dropdown", "list" => ArrayHelper::map(Operator::find()->defaultCondition()->andWhere(['type' => C::OPERATOR_TYPE_DISTRIBUTOR])->asArray()->all(), "id", "name")],
                    ["label" => "Status", "attribute" => "status", "type" => "dropdown", "list" => C::LABEL_SUBSCRIBER_STATUS],
                    ["label" => "Plan", "attribute" => "bouquet_id", "type" => "dropdown", "list" => ArrayHelper::map(PlanMaster::find()->defaultCondition()->active()->asArray()->all(), 'id', 'name')],
                    ["label" => "Added On", "attribute" => "added_on", "type" => "date_range"],
                ];
        }
    }

}
