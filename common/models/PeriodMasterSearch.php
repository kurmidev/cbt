<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\PeriodMaster;
use yii\data\ActiveDataProvider;

/**
 * @property integer $FRM_id
 * @property integer $TO_id
 * @property integer $FRM_days
 * @property integer $TO_days
 * @property integer $FRM_status
 * @property integer $TO_status
 * @property datetime $FRM_added_on
 * @property datetime $TO_added_on
 * @property datetime $FRM_updated_on
 * @property datetime $TO_updated_on
 * @property integer $FRM_added_by
 * @property integer $TO_added_by
 * @property integer $FRM_updated_by
 * @property integer $TO_updated_by
 * PeriodMasterSearch represents the model behind the search form about `common\models\PeriodMaster`.
 */
class PeriodMasterSearch extends PeriodMaster {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'days', 'status', 'added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'added_on', 'updated_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = PeriodMaster::find();


        $dataProvider = new \common\component\ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'days' => $this->days,
            'status' => $this->status,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }

}
