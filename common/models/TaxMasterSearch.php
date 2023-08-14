<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TaxMaster;

/**
 * TaxMasterSearch represents the model behind the search form of `common\models\TaxMaster`.
 */
class TaxMasterSearch extends TaxMaster {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['id', 'type', 'status', 'added_by', 'updated_by'], 'integer'],
                [['name', 'code', 'applicable_on', 'added_on', 'updated_on'], 'safe'],
                [['value'], 'number'],
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
        $query = TaxMaster::find();

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
            'value' => $this->value,
            'status' => $this->status,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'code', $this->code])
                ->andFilterWhere(['like', 'applicable_on', $this->applicable_on]);

        return $dataProvider;
    }

}
