<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Operator;
use common\ebl\Constants as C;
use common\component\Utils as U;
use yii\helpers\Html;
use common\component\Utils;

/**
 * OperatorSearch represents the model behind the search form of `common\models\Operator`.
 */
class OperatorSearch extends Operator {

    public $rate_ids;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'type', 'mso_id', 'distributor_id', 'status', 'state_id', 'city_id', 'billing_by', 'added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'contact_person', 'mobile_no', 'telephone_no', 'email', 'address', 'gst_no', 'pan_no', 'tan_no', 'username', 'meta_data', 'added_on', 'updated_on', 'rate_ids'], 'safe'],
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
        $query = Operator::find();

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

        $query->defaultCondition($query->tableAlias);

        if (!empty($this->rate_ids)) {
            $plan_ids = OperatorRates::find()->where(['rate_id' => $this->rate_ids, 'type' => C::RATE_TYPE_BOUQUET])
                            ->andFilterWhere(['operator_id' => $this->id])
                            ->indexBy('operator_id')->asArray()->all();
            
            if (!empty($plan_ids)) {
                $query->andWhere(['not in', 'id', array_keys($plan_ids)]);
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            $query->tableAlias . 'id' => $this->id,
            $query->tableAlias . 'type' => $this->type,
            $query->tableAlias . 'mso_id' => $this->mso_id,
            $query->tableAlias . 'distributor_id' => $this->distributor_id,
            $query->tableAlias . 'status' => $this->status,
            $query->tableAlias . 'state_id' => $this->state_id,
            $query->tableAlias . 'city_id' => $this->city_id,
            $query->tableAlias . 'billing_by' => $this->billing_by,
            $query->tableAlias . 'added_on' => $this->added_on,
            $query->tableAlias . 'updated_on' => $this->updated_on,
            $query->tableAlias . 'added_by' => $this->added_by,
            $query->tableAlias . 'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', $query->tableAlias . 'name', $this->name])
                ->andFilterWhere(['like', $query->tableAlias . 'code', $this->code])
                ->andFilterWhere(['like', $query->tableAlias . 'contact_person', $this->contact_person])
                ->andFilterWhere(['like', $query->tableAlias . 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', $query->tableAlias . 'telephone_no', $this->telephone_no])
                ->andFilterWhere(['like', $query->tableAlias . 'email', $this->email])
                ->andFilterWhere(['like', $query->tableAlias . 'address', $this->address])
                ->andFilterWhere(['like', $query->tableAlias . 'gst_no', $this->gst_no])
                ->andFilterWhere(['like', $query->tableAlias . 'pan_no', $this->pan_no])
                ->andFilterWhere(['like', $query->tableAlias . 'tan_no', $this->tan_no])
                ->andFilterWhere(['like', $query->tableAlias . 'username', $this->username])
                ->andFilterWhere(['like', $query->tableAlias . 'meta_data', $this->meta_data]);

        return $dataProvider;
    }

    public function displayColumn($type) {
        $actionText = ($type == C::OPERATOR_TYPE_DISTRIBUTOR) ? "distributor" :
                ($type == C::OPERATOR_TYPE_RO ? "ro" : "franchise");

        switch ($type) {
            case C::OPERATOR_TYPE_RO:
                return [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'code',
                    'username',
                    'contact_person',
                    'city.name:text:City',
                    ['attribute' => 'status', 'label' => 'Status',
                        'content' => function ($model) {
                            return U::getLabels(C::LABEL_STATUS, $model->status);
                        },
                        'filter' => C::LABEL_STATUS,
                    ],
                    [
                        "label" => "Balance",
                        "content" => function ($model) {
                            return $model->balance;
                        }],
                    'actionOn',
                    'actionBy',
                    [
                        'label' => 'Action',
                        'content' => function ($model) use ($actionText) {
                            $link[] = Html::a('View Details', Yii::$app->urlManager->createUrl(["operator/view-$actionText", 'id' => $model->id]), ["class" => "nav-link"]);
                            $link[] = Html::a('Update Details', Yii::$app->urlManager->createUrl(["operator/update-$actionText", 'id' => $model->id]), ["class" => "nav-link"]);
                            $link[] = Html::a('Add Credit/Debit', Yii::$app->urlManager->createUrl(['operator/credit-debit', 'id' => $model->id]), ["class" => "nav-link"]);
                            $link[] = Html::a('Wallet Topup', Yii::$app->urlManager->createUrl(["operator/recharge-$actionText", 'id' => $model->id]), ["class" => "nav-link"]);
                            $head = Html::a(Html::tag("div", Html::tag("span", '', ["class" => "mg-r-5 tx-13 tx-medium fa fa-gear"]) .
                                                    Html::tag("i", '', ["class" => "fa fa-angle-down mg-l-5"])
                                                    , ["class" => "ht-45 pd-x-20 bd d-flex align-items-center justify-content-center"])
                                            , '', ["class" => "tx-gray-800 d-inline-block", "data-toggle" => "dropdown"]);

                            $navlist = Html::tag('div', Html::tag('nav', implode(" ", $link)
                                                    , ['class' => 'nav nav-style-2 flex-column'])
                                            , ['class' => 'dropdown-menu pd-10 wd-200']
                            );

                            return Html::tag('div', $head . $navlist, ['class' => 'dropdown']);
                        }
                    ]
                ];

            case C::OPERATOR_TYPE_DISTRIBUTOR:
                return [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'code',
                    'username',
                    'ro.name:text:RO',
                    'ro.code:text:RO Code',
                    'contact_person',
                    'city.name:text:City',
                    ['attribute' => 'status', 'label' => 'Status',
                        'content' => function ($model) {
                            return Utils::getLabels(C::LABEL_STATUS, $model->status);
                        },
                        'filter' => C::LABEL_STATUS,
                    ],
                    [
                        "label" => "Balance",
                        "content" => function ($model) {
                            return $model->balance;
                        }],
                    'actionOn',
                    'actionBy',
                    [
                        'label' => 'Action',
                        'content' => function ($model) use ($actionText) {
                            $link[] = Html::a('View Details', Yii::$app->urlManager->createUrl(["operator/view-$actionText", 'id' => $model->id]), ["class" => "nav-link"]);
                            $link[] = Html::a('Update Details', Yii::$app->urlManager->createUrl(["operator/update-$actionText", 'id' => $model->id]), ["class" => "nav-link"]);
                            $link[] = Html::a('Add Credit/Debit', Yii::$app->urlManager->createUrl(['operator/credit-debit', 'id' => $model->id]), ["class" => "nav-link"]);
                            $link[] = Html::a('Wallet Topup', Yii::$app->urlManager->createUrl(["operator/recharge-$actionText", 'id' => $model->id]), ["class" => "nav-link"]);
                            $head = Html::a(Html::tag("div", Html::tag("span", '', ["class" => "mg-r-5 tx-13 tx-medium fa fa-gear"]) .
                                                    Html::tag("i", '', ["class" => "fa fa-angle-down mg-l-5"])
                                                    , ["class" => "ht-45 pd-x-20 bd d-flex align-items-center justify-content-center"])
                                            , '', ["class" => "tx-gray-800 d-inline-block", "data-toggle" => "dropdown"]);

                            $navlist = Html::tag('div', Html::tag('nav', implode(" ", $link)
                                                    , ['class' => 'nav nav-style-2 flex-column'])
                                            , ['class' => 'dropdown-menu pd-10 wd-200']
                            );

                            return Html::tag('div', $head . $navlist, ['class' => 'dropdown']);
                        }
                    ]
                ];

            case C::OPERATOR_TYPE_LCO:
                return [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'code',
                    'username',
                    'ro.name:text:RO',
                    'ro.code:text:RO Code',
                    'distributor.name:text:Distributor',
                    'distributor.code:text:Distributor Code',
                    'contact_person',
                    'city.name:text:City',
                    ['attribute' => 'status', 'label' => 'Status',
                        'content' => function ($model) {
                            return Utils::getLabels(C::LABEL_STATUS, $model->status);
                        },
                        'filter' => C::LABEL_STATUS,
                    ],
                    [
                        "label" => "Balance",
                        "content" => function ($model) {
                            return $model->balance;
                        }],
                    'actionOn',
                    'actionBy',
                    [
                        'label' => 'Action',
                        'content' => function ($model) use ($actionText) {
                            $link[] = Html::a('View Details', Yii::$app->urlManager->createUrl(["operator/view-$actionText", 'id' => $model->id]), ["class" => "nav-link"]);
                            $link[] = Html::a('Update Details', Yii::$app->urlManager->createUrl(["operator/update-$actionText", 'id' => $model->id]), ["class" => "nav-link"]);
                            $link[] = Html::a('Add Credit/Debit', Yii::$app->urlManager->createUrl(['operator/credit-debit', 'id' => $model->id]), ["class" => "nav-link"]);
                            $link[] = Html::a('Wallet Topup', Yii::$app->urlManager->createUrl(["operator/recharge-$actionText", 'id' => $model->id]), ["class" => "nav-link"]);
                            $head = Html::a(Html::tag("div", Html::tag("span", '', ["class" => "mg-r-5 tx-13 tx-medium fa fa-gear"]) .
                                                    Html::tag("i", '', ["class" => "fa fa-angle-down mg-l-5"])
                                                    , ["class" => "ht-45 pd-x-20 bd d-flex align-items-center justify-content-center"])
                                            , '', ["class" => "tx-gray-800 d-inline-block", "data-toggle" => "dropdown"]);

                            $navlist = Html::tag('div', Html::tag('nav', implode(" ", $link)
                                                    , ['class' => 'nav nav-style-2 flex-column'])
                                            , ['class' => 'dropdown-menu pd-10 wd-200']
                            );

                            return Html::tag('div', $head . $navlist, ['class' => 'dropdown']);
                        }
                    ]
                ];
            default :
                return [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'code',
                    'contact_person',
                    'mobile_no',
                    [
                        'attribute' => 'distributor_id',
                        'label' => C::OPERATOR_TYPE_DISTRIBUTOR_NAME,
                        'content' => function ($model) {
                            return !empty($model->distributor) ? $model->distributor->name : null;
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(Operator::find()->where(['type' => C::OPERATOR_TYPE_DISTRIBUTOR])->all(), 'id', 'name'),
                    ],
                    [
                        'attribute' => 'distributor_id',
                        'label' => C::OPERATOR_TYPE_DISTRIBUTOR_NAME . " Code",
                        'content' => function ($model) {
                            return !empty($model->distributor) ? $model->distributor->code : null;
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(Operator::find()->where(['type' => C::OPERATOR_TYPE_DISTRIBUTOR])->all(), 'id', 'name'),
                    ],
                    'balance'
                ];
        }
    }

}
