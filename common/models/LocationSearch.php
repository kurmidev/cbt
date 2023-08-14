<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Location;

/**
 * LocationSearch represents the model behind the search form of `common\models\Location`.
 */
class LocationSearch extends Location {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'type', 'state_id', 'city_id', 'area_id', 'road_id', 'status', 'added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'added_on', 'updated_on'], 'safe'],
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
        $query = Location::find();

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
            'type' => $this->type,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'area_id' => $this->area_id,
            'road_id' => $this->road_id,
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
