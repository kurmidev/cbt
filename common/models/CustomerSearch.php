<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer;

/**
 * CustomerSearch represents the model behind the search form of `common\models\Customer`.
 */
class CustomerSearch extends Customer {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'connection_type', 'operator_id', 'road_id', 'added_by', 'updated_by'], 'integer'],
            [['cid', 'name', 'mobile_no', 'phone_no', 'email', 'gender', 'dob', 'building_id', 'address', 'billing_address', 'gst_no', 'added_on', 'updated_on'], 'safe'],
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
        $query = Customer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
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
            'dob' => $this->dob,
            'connection_type' => $this->connection_type,
            'operator_id' => $this->operator_id,
            'road_id' => $this->road_id,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'cid', $this->cid])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'phone_no', $this->phone_no])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'gender', $this->gender])
                ->andFilterWhere(['like', 'building_id', $this->building_id])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'billing_address', $this->billing_address])
                ->andFilterWhere(['like', 'gst_no', $this->gst_no]);

        return $dataProvider;
    }

}
