<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\VendorMaster;

/**
 * VendorMasterSearch represents the model behind the search form of `common\models\VendorMaster`.
 */
class VendorMasterSearch extends VendorMaster {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'status', 'added_by', 'updated_by'], 'integer'],
            [['name', 'code', 'point_of_contact', 'mobile_no', 'email', 'address', 'pan_no', 'gst_no', 'added_on', 'updated_on'], 'safe'],
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
        $query = VendorMaster::find();

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
            'status' => $this->status,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'code', $this->code])
                ->andFilterWhere(['like', 'point_of_contact', $this->point_of_contact])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'pan_no', $this->pan_no])
                ->andFilterWhere(['like', 'gst_no', $this->gst_no]);

        return $dataProvider;
    }

}
