<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Account;

/**
 * AccountSearch represents the model behind the search form of `common\models\Account`.
 */
class AccountSearch extends Account {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'gender', 'connection_type', 'operator_id', 'road_id', 'building_id', 'nas_id', 'is_auto_renew', 'status', 'added_by', 'updated_by'], 'integer'],
            [['customer_id', 'name', 'username', 'password', 'mobile_no', 'phone_no', 'email', 'dob', 'mac_address', 'static_ip', 'history', 'activation_date', 'deactivation_date', 'address', 'bill_address', 'meta_data', 'other_id', 'added_on', 'updated_on'], 'safe'],
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
        $query = Account::find();

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
            'gender' => $this->gender,
            'dob' => $this->dob,
            'connection_type' => $this->connection_type,
            'operator_id' => $this->operator_id,
            'road_id' => $this->road_id,
            'building_id' => $this->building_id,
            'nas_id' => $this->nas_id,
            'activation_date' => $this->activation_date,
            'deactivation_date' => $this->deactivation_date,
            'is_auto_renew' => $this->is_auto_renew,
            'status' => $this->status,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'customer_id', $this->customer_id])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'phone_no', $this->phone_no])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'mac_address', $this->mac_address])
                ->andFilterWhere(['like', 'static_ip', $this->static_ip])
                ->andFilterWhere(['like', 'history', $this->history])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'bill_address', $this->bill_address])
                ->andFilterWhere(['like', 'meta_data', $this->meta_data])
                ->andFilterWhere(['like', 'other_id', $this->other_id]);

        return $dataProvider;
    }

}
