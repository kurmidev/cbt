<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\VoucherMaster;

/**
 * VoucherMasterSearch represents the model behind the search form of `common\models\VoucherMaster`.
 */
class VoucherMasterSearch extends VoucherMaster {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'operator_id', 'account_id', 'opt_wallet_id', 'cus_wallet_id', 'status', 'is_locked', 'plan_id', 'added_by', 'updated_by'], 'integer'],
            [['coupon', 'username', 'expiry_date', 'remark', 'added_on', 'updated_on'], 'safe'],
            [['opt_amount', 'cust_amount'], 'number'],
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
        $query = VoucherMaster::find();

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
            'operator_id' => $this->operator_id,
            'account_id' => $this->account_id,
            'expiry_date' => $this->expiry_date,
            'opt_wallet_id' => $this->opt_wallet_id,
            'cus_wallet_id' => $this->cus_wallet_id,
            'status' => $this->status,
            'is_locked' => $this->is_locked,
            'opt_amount' => $this->opt_amount,
            'cust_amount' => $this->cust_amount,
            'plan_id' => $this->plan_id,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'coupon', $this->coupon])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }

}
