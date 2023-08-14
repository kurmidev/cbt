<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OperatorBill;

/**
 * OperatorBillSearch represents the model behind the search form of `common\models\OperatorBill`.
 */
class OperatorBillSearch extends OperatorBill {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'operator_id', 'distributor_id', 'added_by', 'updated_by'], 'integer'],
            [['bill_no', 'bill_month', 'start_date', 'end_date', 'plan_charges', 'debit_charges', 'credit_charges', 'hardware_charges', 'discount', 'added_on', 'updated_on'], 'safe'],
            [['opening_amount', 'payment', 'debit_charges_nt', 'credit_charges_nt', 'sub_amount', 'sub_amount_tax', 'total_amount', 'total_tax', 'total', 'closing_amount'], 'number'],
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
        $query = OperatorBill::find();

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
            $query->talias . 'operator_id' => $this->operator_id,
            $query->talias . 'distributor_id' => $this->distributor_id,
            $query->talias . 'bill_month' => $this->bill_month,
            $query->talias . 'start_date' => $this->start_date,
            $query->talias . 'end_date' => $this->end_date,
            $query->talias . 'opening_amount' => $this->opening_amount,
            $query->talias . 'payment' => $this->payment,
            $query->talias . 'debit_charges_nt' => $this->debit_charges_nt,
            $query->talias . 'credit_charges_nt' => $this->credit_charges_nt,
            $query->talias . 'sub_amount' => $this->sub_amount,
            $query->talias . 'sub_amount_tax' => $this->sub_amount_tax,
            $query->talias . 'total_amount' => $this->total_amount,
            $query->talias . 'total_tax' => $this->total_tax,
            $query->talias . 'total' => $this->total,
            $query->talias . 'closing_amount' => $this->closing_amount,
            $query->talias . 'added_on' => $this->added_on,
            $query->talias . 'updated_on' => $this->updated_on,
            $query->talias . 'added_by' => $this->added_by,
            $query->talias . 'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', $query->talias . 'bill_no', $this->bill_no])
                ->andFilterWhere(['like', $query->talias . 'plan_charges', $this->plan_charges])
                ->andFilterWhere(['like', $query->talias . 'debit_charges', $this->debit_charges])
                ->andFilterWhere(['like', $query->talias . 'credit_charges', $this->credit_charges])
                ->andFilterWhere(['like', $query->talias . 'hardware_charges', $this->hardware_charges])
                ->andFilterWhere(['like', $query->talias . 'discount', $this->discount]);

        return $dataProvider;
    }

    public function displayColumn() {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            [
                "label" => "",
                "content" => function ($model) {
                    return \yii\helpers\Html::a(\yii\helpers\Html::tag('span', '', ['class' => 'fa fa-print']), \Yii::$app->urlManager->createUrl(['opt-accounting/print-bill', 'id' => $model->id]), ['title' => "Print Bill", 'class' => 'btn btn-primary-alt']);
                }
            ],
            'operator.name',
            'operator.code',
            'distributor.name',
            'distributor.code',
            "bill_no",
            "bill_month",
            "start_date",
            "end_date",
            "opening_amount",
            [
                'attribute' => 'plan_charges',
                'label' => "Current Charges",
                'content' => function ($model) {
                    return $model->plan_charges['amount'];
                },
            ],
            [
                'attribute' => 'plan_charges',
                'label' => "Current Tax",
                'content' => function ($model) {
                    return $model->plan_charges['tax'];
                },
            ],
            [
                'attribute' => 'debit_charges',
                'label' => "Debit Amount",
                'content' => function ($model) {
                    return $model->debit_charges['amount'];
                },
            ],
            [
                'attribute' => 'debit_charges',
                'label' => "Debit Tax",
                'content' => function ($model) {
                    return $model->debit_charges['tax'];
                },
            ],
            [
                'attribute' => 'credit_charges',
                'label' => "Credit Amount",
                'content' => function ($model) {
                    return $model->credit_charges['amount'];
                },
            ],
            [
                'attribute' => 'credit_charges',
                'label' => "Credit Tax",
                'content' => function ($model) {
                    return $model->credit_charges['tax'];
                },
            ],
            "sub_amount",
            "sub_amount_tax",
            "payment",
            "debit_charges_nt",
            "credit_charges_nt",
            "hardware_charges",
            "total",
            "closing_amount",
        ];
    }

}
