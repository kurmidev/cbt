<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BouquetAssets;

/**
 * BouquetAssetsSearch represents the model behind the search form of `common\models\BouquetAssets`.
 */
class BouquetAssetsSearch extends BouquetAssets {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'type', 'status', 'mapped_id', 'added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'added_on', 'updated_on'], 'safe'],
            [['price'], 'number'],
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
        $query = BouquetAssets::find();

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
            'type' => $this->type,
            'price' => $this->price,
            'status' => $this->status,
            'mapped_id' => $this->mapped_id,
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
