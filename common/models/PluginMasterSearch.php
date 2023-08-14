<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PluginsMaster;

/**
 * PluginMasterSearch represents the model behind the search form of `common\models\PluginsMaster`.
 */
class PluginMasterSearch extends PluginsMaster {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'plugin_type', 'status', 'added_by', 'updated_by'], 'integer'],
            [['name', 'plugin_url', 'meta_data', 'description', 'added_on', 'updated_on'], 'safe'],
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
        $query = PluginsMaster::find();

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
            'plugin_type' => $this->plugin_type,
            'status' => $this->status,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'plugin_url', $this->plugin_url])
                ->andFilterWhere(['like', 'meta_data', $this->meta_data])
                ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
