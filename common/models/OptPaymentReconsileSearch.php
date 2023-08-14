<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OptPaymentReconsile;
use common\ebl\Constants as C;

/**
 * OptPaymentReconsileSearch represents the model behind the search form of `common\models\OptPaymentReconsile`.
 */
class OptPaymentReconsileSearch extends OptPaymentReconsile {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'wallet_id', 'status', 'deposited_by', 'realised_by', 'added_by', 'updated_by'], 'integer'],
            [['inst_no', 'inst_date', 'bank', 'receipt_no', 'deposited_bank', 'desposited_on', 'realized_on', 'remark', 'added_on', 'updated_on'], 'safe'],
            [['amount', 'tax'], 'number'],
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
        $query = OptPaymentReconsile::find();

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
            'inst_date' => $this->inst_date,
            'wallet_id' => $this->wallet_id,
            'amount' => $this->amount,
            'tax' => $this->tax,
            'status' => $this->status,
            'deposited_by' => $this->deposited_by,
            'desposited_on' => $this->desposited_on,
            'realized_on' => $this->realized_on,
            'realised_by' => $this->realised_by,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'inst_no', $this->inst_no])
                ->andFilterWhere(['like', 'bank', $this->bank])
                ->andFilterWhere(['like', 'receipt_no', $this->receipt_no])
                ->andFilterWhere(['like', 'deposited_bank', $this->deposited_bank])
                ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }

    public function displayColumn($type) {
        $ret = [];
        switch ($type) {
            case 1:
                return [
                    ['class' => 'yii\grid\SerialColumn'],
                    'wallet.operator.name:text:' . C::OPERATOR_TYPE_LCO_NAME,
                    'wallet.operator.code:text:' . C::OPERATOR_TYPE_LCO_NAME . " Code",
                    'receipt_no:text:Receipt No',
                    'amount:decimal:Amount',
                    'inst_no:text:Instrument Number',
                    'inst_date:date:Instrument Date',
                    'bank:text:Bank',
                    'remark:text:Remark',
                ];

                break;
            case 2:
                return [
                    ['class' => 'yii\grid\SerialColumn'],
                    'wallet.operator.name:text:' . C::OPERATOR_TYPE_LCO_NAME,
                    'wallet.operator.code:text:' . C::OPERATOR_TYPE_LCO_NAME . " Code",
                    'receipt_no:text:Receipt No',
                    'amount:decimal:Amount',
                    'inst_no:text:Instrument Number',
                    'inst_date:date:Instrument Date',
                    'bank:text:Bank',
                    'remark:text:Remark',
                    'desposited_on:date:Deposited On',
                    'deposited_bank:text:Deposited Bank',
                    'deposited_by_lbl:text:Deposited By'
                ];
                break;
            default :
                return[
                    ['class' => 'yii\grid\SerialColumn'],
                    'wallet.operator.name:text:' . C::OPERATOR_TYPE_LCO_NAME,
                    'wallet.operator.code:text:' . C::OPERATOR_TYPE_LCO_NAME . " Code",
                    'receipt_no:text:Receipt No',
                    'amount:decimal:Amount',
                    'inst_no:text:Instrument Number',
                    'inst_date:date:Instrument Date',
                    'bank:text:Bank',
                    'remark:text:Remark',
                    'deposited_bank:text:Deposited Bank',
                    'desposited_on:date:Deposited On',
                    'deposited_by_lbl:text:Deposited By',
                    'realized_on:date:Realised On',
                    'Realised_by_lbl:text:Realised By',
                ];
                break;
        }

        return $ret;
    }

}
