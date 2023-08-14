<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PlanPolicy;

/**
 * PlanPolicySearch represents the model behind the search form of `common\models\PlanPolicy`.
 */
class PlanPolicySearch extends PlanPolicy {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'days', 'total_time', 'limit_type', 'limit_value', 'limit_unit', 'pre_upload', 'pre_download', 'post_upload', 'post_download', 'status', 'added_by', 'updated_by'], 'integer'],
            [['name', 'start_time', 'end_time', 'extra_config', 'added_on', 'updated_on'], 'safe'],
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
        $query = PlanPolicy::find();

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
            'days' => $this->days,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'total_time' => $this->total_time,
            'limit_type' => $this->limit_type,
            'limit_value' => $this->limit_value,
            'limit_unit' => $this->limit_unit,
            'pre_upload' => $this->pre_upload,
            'pre_download' => $this->pre_download,
            'post_upload' => $this->post_upload,
            'post_download' => $this->post_download,
            'status' => $this->status,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'extra_config', $this->extra_config]);

        return $dataProvider;
    }

}
