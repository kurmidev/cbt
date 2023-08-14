<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OperatorRates;

/**
 * OperatorRatesSearch represents the model behind the search form of `common\models\OperatorRates`.
 */
class OperatorRatesSearch extends OperatorRates {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'operator_id', 'assoc_id', 'type', 'rate_id', 'added_by', 'updated_by'], 'integer'],
            [['amount', 'tax', 'mrp', 'mrp_tax'], 'number'],
            [['added_on', 'updated_on'], 'safe'],
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
        $query = OperatorRates::find();

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
            $query->talias . 'assoc_id' => $this->assoc_id,
            $query->talias . 'type' => $this->type,
            $query->talias . 'rate_id' => $this->rate_id,
            $query->talias . 'amount' => $this->amount,
            $query->talias . 'tax' => $this->tax,
            $query->talias . 'mrp' => $this->mrp,
            $query->talias . 'mrp_tax' => $this->mrp_tax,
            $query->talias . 'added_on' => $this->added_on,
            $query->talias . 'updated_on' => $this->updated_on,
            $query->talias . 'added_by' => $this->added_by,
            $query->talias . 'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }

}
