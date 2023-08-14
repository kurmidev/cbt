<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PlanMaster;

/**
 * PlanMasterSearch represents the model behind the search form of `common\models\PlanMaster`.
 */
class PlanMasterSearch extends PlanMaster {

    public $operator_id;
    public $ex_operator_id;
    public $is_rate_required;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'is_exclusive', 'is_promotional', 'plan_type', 'billing_type', 'status', 'days', 'free_days', 'reset_type', 'limit_type', 'added_by', 'updated_by', 'is_rate_required'], 'integer'],
            [['name', 'code', 'display_name', 'applicable_days', 'description', 'meta_data', 'added_on', 'updated_on', 'operator_id', 'ex_operator_id'], 'safe'],
            [['reset_value', 'upload', 'download', 'post_upload', 'post_download', 'limit_value'], 'number'],
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
        $query = PlanMaster::find();
        $query->setAlias('a');

        // add conditions that should always apply here

        $dataProvider = new \common\component\ActiveDataProvider([
            'query' => $query,
        ]);

        if ($this->is_rate_required) {
            $query->joinWith(['rates r'])->andWhere(['not', ['r.id' => null]]);
        }
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
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
            $query->innerJoin('operator_rates b', $query->tableAlias . 'id=b.assoc_id and b.type=' . $this->plan_type)
                    ->andFilterWhere(['b.operator_id' => $this->operator_id]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            $query->tableAlias . 'id' => $this->id,
            $query->tableAlias . 'is_exclusive' => $this->is_exclusive,
            $query->tableAlias . 'is_promotional' => $this->is_promotional,
            $query->tableAlias . 'plan_type' => $this->plan_type,
            $query->tableAlias . 'billing_type' => $this->billing_type,
            $query->tableAlias . 'status' => $this->status,
            $query->tableAlias . 'days' => $this->days,
            $query->tableAlias . 'free_days' => $this->free_days,
            $query->tableAlias . 'reset_type' => $this->reset_type,
            $query->tableAlias . 'reset_value' => $this->reset_value,
            $query->tableAlias . 'upload' => $this->upload,
            $query->tableAlias . 'download' => $this->download,
            $query->tableAlias . 'post_upload' => $this->post_upload,
            $query->tableAlias . 'post_download' => $this->post_download,
            $query->tableAlias . 'limit_type' => $this->limit_type,
            $query->tableAlias . 'limit_value' => $this->limit_value,
            $query->tableAlias . 'added_on' => $this->added_on,
            $query->tableAlias . 'updated_on' => $this->updated_on,
            $query->tableAlias . 'added_by' => $this->added_by,
            $query->tableAlias . 'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', $query->tableAlias . 'name', $this->name])
                ->andFilterWhere(['like', $query->tableAlias . 'code', $this->code])
                ->andFilterWhere(['like', $query->tableAlias . 'display_name', $this->display_name])
                ->andFilterWhere(['like', $query->tableAlias . 'applicable_days', $this->applicable_days])
                ->andFilterWhere(['like', $query->tableAlias . 'description', $this->description])
                ->andFilterWhere(['like', $query->tableAlias . 'meta_data', $this->meta_data]);

        return $dataProvider;
    }

}
