<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StaticipPolicy;

/**
 * StaticipPolicySearch represents the model behind the search form of `common\models\StaticipPolicy`.
 */
class StaticipPolicySearch extends StaticipPolicy {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'days', 'months', 'is_refundable', 'status', 'added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'added_on', 'updated_on'], 'safe'],
            [['amount', 'amount_tax', 'mrp', 'mrp_tax'], 'number'],
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
        $query = StaticipPolicy::find();

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
            'days' => $this->days,
            'months' => $this->months,
            'is_refundable' => $this->is_refundable,
            'amount' => $this->amount,
            'amount_tax' => $this->amount_tax,
            'mrp' => $this->mrp,
            'mrp_tax' => $this->mrp_tax,
            'status' => $this->status,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }

}
