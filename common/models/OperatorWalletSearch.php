<?php

namespace common\models;

use common\models\OperatorWallet;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\ebl\Constants as C;

/**
 * OperatorWalletSearch represents the model behind the search form of `common\models\OperatorWallet`.
 */
class OperatorWalletSearch extends OperatorWallet {

    public $transtype;
    public $notetype;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'cr_operator_id', 'dr_operator_id', 'operator_id', 'transaction_id', 'trans_type', 'cancel_id', 'added_by', 'updated_by'], 'integer'],
            [['amount', 'tax', 'balance'], 'number'],
            [['receipt_no', 'remark', 'meta_data', 'added_on', 'updated_on', 'transtype', 'notetype'], 'safe'],
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
        $query = OperatorWallet::find();

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

        $query->defaultCondition($query->talias);

        if (!empty($this->transtype) && !empty($this->notetype)) {
            $arr = $this->notetype == 1 ? [C::TRANS_DR_OPERATOR_DEBIT_NOTE] : [C::TRANS_CR_OPERATOR_CREDIT_NOTE, C::TRANS_CR_OPERATOR_ONLINE_WALLET_RECHARGE, C::TRANS_CR_OPERATOR_WALLET_RECHARGE];
            $query->andWhere([$query->talias . "trans_type" => $arr]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            $query->talias . 'id' => $this->id,
            $query->talias . 'cr_operator_id' => $this->cr_operator_id,
            $query->talias . 'dr_operator_id' => $this->dr_operator_id,
            $query->talias . 'operator_id' => $this->operator_id,
            $query->talias . 'amount' => $this->amount,
            $query->talias . 'tax' => $this->tax,
            $query->talias . 'transaction_id' => $this->transaction_id,
            $query->talias . 'trans_type' => $this->trans_type,
            $query->talias . 'balance' => $this->balance,
            $query->talias . 'cancel_id' => $this->cancel_id,
            $query->talias . 'added_on' => $this->added_on,
            $query->talias . 'updated_on' => $this->updated_on,
            $query->talias . 'added_by' => $this->added_by,
            $query->talias . 'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', $query->talias . 'receipt_no', $this->receipt_no])
                ->andFilterWhere(['like', $query->talias . 'remark', $this->remark])
                ->andFilterWhere(['like', $query->talias . 'meta_data', $this->meta_data]);

        return $dataProvider;
    }

    public function displayColumn() {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'operator_id',
                'label' => C::OPERATOR_TYPE_LCO_NAME,
                'content' => function ($model) {
                    return !empty($model->operator) ? $model->operator->name : null;
                },
                'filter' => \yii\helpers\ArrayHelper::map(Operator::find()->defaultCondition()->all(), 'id', function ($m) {
                    return "$m->name($m->code) ";
                }),
            ],
            [
                'attribute' => 'operator_id',
                'label' => C::OPERATOR_TYPE_LCO_NAME . " Code",
                'content' => function ($model) {
                    return !empty($model->operator) ? $model->operator->code : null;
                },
            ],
            [
                'label' => C::OPERATOR_TYPE_DISTRIBUTOR_NAME,
                'content' => function ($model) {
                    return !empty($model->operator->distributor) ? $model->operator->distributor->name : null;
                },
            ],
            [
                'label' => C::OPERATOR_TYPE_DISTRIBUTOR_NAME . " Code",
                'content' => function ($model) {
                    return !empty($model->operator->distributor) ? $model->operator->distributor->code : null;
                },
            ],
            [
                "attribute" => "trans_type",
                "label" => "Trans Type",
                "content" => function ($model) {
                    return !empty(C::TRANS_LABEL[$model->trans_type]) ? C::TRANS_LABEL[$model->trans_type] : "";
                }
            ],
            "receipt_no",
            "amount",
            "tax",
            "balance",
            [
                "attribute" => "added_on",
                "label" => "Transaction Date",
                "content" => function ($model) {
                    return $model->addedOnDate;
                }
            ],
            [
                "attribute" => "added_on",
                "label" => "Transaction By",
                "content" => function ($model) {
                    return $model->addedByName;
                },
            ],
        ];
    }

}
