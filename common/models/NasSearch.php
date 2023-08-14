<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Nas;

/**
 * NasSearch represents the model behind the search form of `common\models\Nas`.
 */
class NasSearch extends Nas {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'ports', 'status', 'added_by', 'updated_by'], 'integer'],
            [['ip_address', 'name', 'code', 'type', 'secret', 'description', 'meta_data', 'added_on', 'updated_on', 'username', 'password'], 'safe'],
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
        $query = Nas::find();

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
            'ports' => $this->ports,
            'status' => $this->status,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'ip_address', $this->ip_address])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'code', $this->code])
                ->andFilterWhere(['like', 'type', $this->type])
                ->andFilterWhere(['like', 'secret', $this->secret])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'meta_data', $this->meta_data]);

        return $dataProvider;
    }

}
