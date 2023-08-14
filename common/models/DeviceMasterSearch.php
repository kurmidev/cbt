<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DeviceMaster;

/**
 * DeviceMasterSearch represents the model behind the search form of `common\models\DeviceMaster`.
 */
class DeviceMasterSearch extends DeviceMaster {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'vendor_id', 'status', 'units', 'added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'description', 'device_attributes', 'added_on', 'updated_on'], 'safe'],
            [['amount', 'tax'], 'number'],
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
        $query = DeviceMaster::find();

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
            'vendor_id' => $this->vendor_id,
            'status' => $this->status,
            'amount' => $this->amount,
            'tax' => $this->tax,
            'units' => $this->units,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'code', $this->code])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'device_attributes', $this->device_attributes]);

        return $dataProvider;
    }

}
