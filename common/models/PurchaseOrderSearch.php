<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PurchaseOrder;

/**
 * PurchaseOrderSearch represents the model behind the search form of `common\models\PurchaseOrder`.
 */
class PurchaseOrderSearch extends PurchaseOrder {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'vendor_id', 'device_id', 'quantity', 'added_by', 'updated_by'], 'integer'],
            [['purchase_number', 'purchase_date', 'invoice_number', 'invoice_date', 'warranty_date', 'added_on', 'updated_on'], 'safe'],
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
        $query = PurchaseOrder::find();

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
            'purchase_date' => $this->purchase_date,
            'invoice_date' => $this->invoice_date,
            'vendor_id' => $this->vendor_id,
            'device_id' => $this->device_id,
            'quantity' => $this->quantity,
            'warranty_date' => $this->warranty_date,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'purchase_number', $this->purchase_number])
                ->andFilterWhere(['like', 'invoice_number', $this->invoice_number]);

        return $dataProvider;
    }

}
