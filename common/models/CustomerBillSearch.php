<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CustomerBill;

/**
 * CustomerBillSearch represents the model behind the search form of `common\models\CustomerBill`.
 */
class CustomerBillSearch extends CustomerBill {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'customer_id', 'account_id', 'operator_id', 'added_by', 'updated_by'], 'integer'],
            [['bill_month', 'bill_start_date', 'bill_end_date', 'bill_no', 'subscription_charges', 'debit_charges', 'credit_charges', 'hardware_charges', 'discount', 'added_on', 'updated_on'], 'safe'],
            [['opening', 'debit_charges_nt', 'credit_charges_nt', 'discount_nt', 'sub_amount', 'sub_tax', 'closing'], 'number'],
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
        $query = CustomerBill::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'account_id' => $this->account_id,
            'operator_id' => $this->operator_id,
            'bill_month' => $this->bill_month,
            'bill_start_date' => $this->bill_start_date,
            'bill_end_date' => $this->bill_end_date,
            'opening' => $this->opening,
            'debit_charges_nt' => $this->debit_charges_nt,
            'credit_charges_nt' => $this->credit_charges_nt,
            'discount_nt' => $this->discount_nt,
            'sub_amount' => $this->sub_amount,
            'sub_tax' => $this->sub_tax,
            'closing' => $this->closing,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'bill_no', $this->bill_no])
                ->andFilterWhere(['like', 'subscription_charges', $this->subscription_charges])
                ->andFilterWhere(['like', 'debit_charges', $this->debit_charges])
                ->andFilterWhere(['like', 'credit_charges', $this->credit_charges])
                ->andFilterWhere(['like', 'hardware_charges', $this->hardware_charges])
                ->andFilterWhere(['like', 'discount', $this->discount]);

        return $dataProvider;
    }

    public function displayColumn() {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            [
                "label" => "",
                "content" => function ($model) {
                    return \yii\helpers\Html::a(\yii\helpers\Html::tag('span', '', ['class' => 'fa fa-print']), \Yii::$app->urlManager->createUrl(['cust-accounting/print-bill', 'id' => $model->id]), ['title' => "Print Bill", 'class' => 'btn btn-primary-alt']);
                }
            ],
            'customer.name',
            'operator.name',
            'operator.code',
            'operator.distributor.name',
            'operator.distributor.code',
            "bill_no",
            "bill_month",
            "bill_start_date",
            "bill_end_date",
            "opening",
            [
                'attribute' => 'subscription_charges',
                'label' => "Current Charges",
                'content' => function ($model) {
                    return $model->subscription_charges['amount'];
                },
            ],
            [
                'attribute' => 'subscription_charges',
                'label' => "Current Tax",
                'content' => function ($model) {
                    return $model->subscription_charges['tax'];
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
            "sub_tax",
            "payment",
            "debit_charges_nt",
            "credit_charges_nt",
            "hardware_charges",
            "total",
            "closing",
        ];
    }

}
