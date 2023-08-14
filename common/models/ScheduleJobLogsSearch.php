<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ScheduleJobLogs;

/**
 * ScheduleJobLogsSearch represents the model behind the search form of `common\models\ScheduleJobLogs`.
 */
class ScheduleJobLogsSearch extends ScheduleJobLogs {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['_id', 'model', 'model_name', 'model_data', 'type', 'status', 'job_id', 'meta_data', 'total_record', 'error_record', 'success_record', 'time_taken', 'response', 'file_path', 'locked_on', 'added_on', 'added_by', 'updated_on', 'updated_by'], 'safe'],
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
        $query = ScheduleJobLogs::find();

        // add conditions that should always apply here

        $dataProvider = new \common\component\ActiveMongoDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->_id)) {
            $query->andFilterWhere(['_id' => (int) $this->_id]);
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'model', $this->model])
                ->andFilterWhere(['like', 'model_name', $this->model_name])
                ->andFilterWhere(['like', 'model_data', $this->model_data])
                ->andFilterWhere(['like', 'type', $this->type])
                ->andFilterWhere(['like', 'status', $this->status])
                ->andFilterWhere(['like', 'job_id', $this->job_id])
                ->andFilterWhere(['like', 'meta_data', $this->meta_data])
                ->andFilterWhere(['like', 'total_record', $this->total_record])
                ->andFilterWhere(['like', 'error_record', $this->error_record])
                ->andFilterWhere(['like', 'success_record', $this->success_record])
                ->andFilterWhere(['like', 'time_taken', $this->time_taken])
                ->andFilterWhere(['like', 'response', $this->response])
                ->andFilterWhere(['like', 'file_path', $this->file_path])
                ->andFilterWhere(['like', 'locked_on', $this->locked_on])
                ->andFilterWhere(['like', 'added_on', $this->added_on])
                ->andFilterWhere(['like', 'added_by', $this->added_by])
                ->andFilterWhere(['like', 'updated_on', $this->updated_on])
                ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }

}
