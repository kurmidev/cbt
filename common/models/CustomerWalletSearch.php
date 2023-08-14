<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CustomerWallet;
use common\ebl\Constants as C;

/**
 * CustomerWalletSearch represents the model behind the search form of `common\models\CustomerWallet`.
 */
class CustomerWalletSearch extends CustomerWallet {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'subscriber_id', 'account_id', 'operator_id', 'trans_type', 'cancel_id', 'added_by', 'updated_by'], 'integer'],
            [['amount', 'tax', 'balance'], 'number'],
            [['receipt_no', 'remark', 'meta_data', 'added_on', 'updated_on'], 'safe'],
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
        $query = CustomerWallet::find();

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
        // grid filtering conditions
        $query->andFilterWhere([
            $query->talias . 'id' => $this->id,
            $query->talias . 'subscriber_id' => $this->subscriber_id,
            $query->talias . 'account_id' => $this->account_id,
            $query->talias . 'operator_id' => $this->operator_id,
            $query->talias . 'trans_type' => $this->trans_type,
            $query->talias . 'amount' => $this->amount,
            $query->talias . 'tax' => $this->tax,
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

    public function displayColumn($type) {
        switch ($type) {
            case "trans":
                return [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'subscriber_id',
                        'label' => "Name",
                        'content' => function ($model) {
                            return !empty($model->customer) ? $model->customer->name : null;
                        },
                    ],
                    [
                        'attribute' => 'account_id',
                        'label' => "UserName",
                        'content' => function ($model) {
                            return !empty($model->account) ? $model->account->username : null;
                        },
                    ],
                    [
                        'attribute' => 'operator_id',
                        'label' => C::OPERATOR_TYPE_LCO_NAME . " Code",
                        'content' => function ($model) {
                            return !empty($model->operator) ? $model->operator->code : null;
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(Operator::find()->defaultCondition()->all(), 'id', function ($m) {
                            return "$m->name($m->code) ";
                        }),
                    ],
                    'remark',
                    "receipt_no",
                    [
                        "attribute" => "trans_type",
                        "label" => "Trans Type",
                        "content" => function ($model) {
                            return !empty(C::TRANS_LABEL[$model->trans_type]) ? C::TRANS_LABEL[$model->trans_type] : "";
                        },
                        'filter' => C::TRANS_LABEL
                    ],
                    [
                        "label" => "Credit",
                        "content" => function ($model) {
                            return in_array($model->trans_type, C::TRANSACTION_TYPE_SUB_CREDIT) ? $model->amount : 0;
                        },
                    ],
                    [
                        "label" => "Debit",
                        "content" => function ($model) {
                            return !in_array($model->trans_type, C::TRANSACTION_TYPE_SUB_CREDIT) ? $model->amount : 0;
                        },
                    ],
                    "tax",
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
                        }
                    ],
                ];
                break;
            case "coll":
                return [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'subscriber_id',
                        'label' => "Name",
                        'content' => function ($model) {
                            return !empty($model->customer) ? $model->customer->name : null;
                        },
                    ],
                    [
                        'attribute' => 'account_id',
                        'label' => "UserName",
                        'content' => function ($model) {
                            return !empty($model->account) ? $model->account->username : null;
                        },
                    ],
                    [
                        'attribute' => 'operator_id',
                        'label' => C::OPERATOR_TYPE_LCO_NAME,
                        'content' => function ($model) {
                            return !empty($model->operator) ? $model->operator->name : "ksks";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(Operator::find()->defaultCondition()->all(), 'id', function ($m) {
                            return "$m->name($m->code) ";
                        }),
                    ],
                    'remark',
                    "receipt_no",
                    [
                        "attribute" => "trans_type",
                        "label" => "Trans Type",
                        "content" => function ($model) {
                            return !empty(C::TRANS_LABEL[$model->trans_type]) ? C::TRANS_LABEL[$model->trans_type] : "";
                        },
                        'filter' => C::TRANS_LABEL
                    ],
                    [
                        "label" => "Instrument No",
                        "content" => function ($model) {
                            return !empty($model->meta_data["instrument_mode"]) ? $model->meta_data["instrument_mode"] : "";
                        }
                    ],
                    [
                        "label" => "Instrument Bank",
                        "content" => function ($model) {
                            return !empty($model->meta_data["instrument_bank"]) ? $model->meta_data["instrument_bank"] : "";
                        }
                    ],
                    [
                        "label" => "Instrument Date",
                        "content" => function ($model) {
                            return !empty($model->meta_data["instrument_date"]) ? date("d m y", strtotime($model->meta_data["instrument_date"])) : "";
                        }
                    ],
                    "amount",
                    "tax",
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
                        }
                    ],
                ];
                break;
            default :

                break;
        }
    }

}
