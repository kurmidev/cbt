<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Services;

/**
 * ServicesSearch represents the model behind the search form of `common\models\Services`.
 */
class ServicesSearch extends Services
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'service_type', 'type', 'broadcaster_id', 'language_id', 'genre_id', 'is_alacarte', 'is_fta', 'status', 'added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'description', 'meta_data', 'added_on', 'updated_on'], 'safe'],
            [['rate'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = Services::find();

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
            'service_type' => $this->service_type,
            'type' => $this->type,
            'broadcaster_id' => $this->broadcaster_id,
            'language_id' => $this->language_id,
            'genre_id' => $this->genre_id,
            'is_alacarte' => $this->is_alacarte,
            'is_fta' => $this->is_fta,
            'rate' => $this->rate,
            'status' => $this->status,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'meta_data', $this->meta_data]);

        return $dataProvider;
    }
}
