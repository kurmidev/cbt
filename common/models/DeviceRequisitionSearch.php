<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DeviceRequisition;

/**
 * DeviceRequisitionSearch represents the model behind the search form of `common\models\DeviceRequisition`.
 */
class DeviceRequisitionSearch extends DeviceRequisition {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'company_id', 'status', 'state', 'approved_quantity', 'purchased_quantity', 'added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'description', 'approval_meta_data', 'meta_data', 'added_on', 'updated_on'], 'safe'],
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
        $query = DeviceRequisition::find();

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
            'company_id' => $this->company_id,
            'status' => $this->status,
            'state' => $this->state,
            'approved_quantity' => $this->approved_quantity,
            'purchased_quantity' => $this->purchased_quantity,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'code', $this->code])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'approval_meta_data', $this->approval_meta_data])
                ->andFilterWhere(['like', 'meta_data', $this->meta_data]);

        return $dataProvider;
    }

}
