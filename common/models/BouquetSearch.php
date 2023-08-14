<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Bouquet;

/**
 * BouquetSearch represents the model behind the search form of `common\models\Bouquet`.
 */
class BouquetSearch extends Bouquet {

    public $operator_id;
    public $ex_operator_id;
    public $is_rate_required;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'status', 'days', 'bill_type', 'is_online', 'type', 'added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'description', 'meta_data', 'added_on', 'updated_on'], 'safe'],
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
        $query = Bouquet::find();
        $query->setAlias('a');

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

        if ($this->is_rate_required) {
            $query->joinWith(['rates r'])->andWhere(['not', ['r.id' => null]]);
        }

        if (!empty($this->ex_operator_id)) {
            $optassoc = OperatorRates::find()->where(['operator_id' => $this->ex_operator_id, 'type' => 1])
                            ->indexBy('assoc_id')->asArray()->all();
            if (!empty($optassoc)) {
                $query->andWhere(['not in ', $query->tableAlias . 'id', array_keys($optassoc)]);
            }
        }

        $query->defaultCondition($query->tableAlias);
        if ($this->operator_id) {
            $query->innerJoin('operator_rates b', $query->tableAlias . 'id=b.assoc_id ')
                    ->andFilterWhere(['b.operator_id' => $this->operator_id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'days' => $this->days,
            'bill_type' => $this->bill_type,
            'is_online' => $this->is_online,
            'type' => $this->type,
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
