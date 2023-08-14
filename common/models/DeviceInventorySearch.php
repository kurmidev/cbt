<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DeviceInventory;

/**
 * DeviceInventorySearch represents the model behind the search form of `common\models\DeviceInventory`.
 */
class DeviceInventorySearch extends DeviceInventory {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'vendor_id', 'device_id', 'operator_id', 'account_id', 'purchase_order_id', 'locked_at', 'status', 'added_by', 'updated_by'], 'integer'],
            [['warranty_date', 'serial_no', 'meta_data', 'operator_scheme', 'customer_scheme', 'locked_token', 'added_on', 'updated_on'], 'safe'],
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
        $query = DeviceInventory::find();

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
            'vendor_id' => $this->vendor_id,
            'device_id' => $this->device_id,
            'warranty_date' => $this->warranty_date,
            'operator_id' => $this->operator_id,
            'account_id' => $this->account_id,
            'purchase_order_id' => $this->purchase_order_id,
            'locked_at' => $this->locked_at,
            'status' => $this->status,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'serial_no', $this->serial_no])
                ->andFilterWhere(['like', 'meta_data', $this->meta_data])
                ->andFilterWhere(['like', 'operator_scheme', $this->operator_scheme])
                ->andFilterWhere(['like', 'customer_scheme', $this->customer_scheme])
                ->andFilterWhere(['like', 'locked_token', $this->locked_token]);

        return $dataProvider;
    }

}
