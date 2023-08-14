<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProspectSubscriber;
use common\ebl\Constants as C;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * ProspectSubscriberSearch represents the model behind the search form of `common\models\ProspectSubscriber`.
 */
class ProspectSubscriberSearch extends ProspectSubscriber {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'gender', 'connection_type', 'stages', 'operator_id', 'subscriber_id', 'account_id', 'assigned_engg', 'is_verified', 'is_verified_by', 'status', 'added_by', 'updated_by'], 'integer'],
            [['ticket_no', 'name', 'mobile_no', 'email', 'phone_no', 'address', 'area_name', 'description', 'is_verified_on', 'meta_data', 'next_follow', 'added_on', 'updated_on'], 'safe'],
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
        $query = ProspectSubscriber::find();

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
            $query->talias . 'gender' => $this->gender,
            $query->talias . 'connection_type' => $this->connection_type,
            $query->talias . 'stages' => $this->stages,
            $query->talias . 'operator_id' => $this->operator_id,
            $query->talias . 'subscriber_id' => $this->subscriber_id,
            $query->talias . 'account_id' => $this->account_id,
            $query->talias . 'assigned_engg' => $this->assigned_engg,
            $query->talias . 'is_verified' => $this->is_verified,
            $query->talias . 'is_verified_on' => $this->is_verified_on,
            $query->talias . 'is_verified_by' => $this->is_verified_by,
            $query->talias . 'status' => $this->status,
            $query->talias . 'next_follow' => $this->next_follow,
            $query->talias . 'added_on' => $this->added_on,
            $query->talias . 'updated_on' => $this->updated_on,
            $query->talias . 'added_by' => $this->added_by,
            $query->talias . 'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'ticket_no', $this->ticket_no])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'phone_no', $this->phone_no])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'area_name', $this->area_name])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'meta_data', $this->meta_data]);

        return $dataProvider;
    }

    public function displayColumn() {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'Action',
                'content' => function ($data) {
                    if ($data['stages'] !== C::PROSPECT_CALL_CLOSED)
                        return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['prospect/process-request', 'id' => $data['id']]), ['title' => 'Process ' . $data['name'], 'class' => 'btn btn-primary-alt']);
                }
            ],
            'ticket_no',
            ['attribute' => 'stages', 'label' => 'Stage',
                'content' => function ($model) {
                    return !empty(C::PROSPECT_SATGES[$model->stages]) ? C::PROSPECT_SATGES[$model->stages] : null;
                },
                'filter' => C::PROSPECT_SATGES,
            ],
            'name',
            'mobile_no',
            ['attribute' => 'mobile_no', 'label' => 'Mobile No<br>Phone No',
                'content' => function ($model) {
                    return $model->mobile_no . '<br/>' . $model->phone_no;
                },
            ],
            'phone_no',
            'address',
            'area_name',
            'next_follow',
            ['attribute' => 'connection_type', 'label' => 'Connection Type',
                'content' => function ($model) {
                    return !empty(C::LABEL_CONNECTION_TYPE[$model->connection_type]) ? C::LABEL_CONNECTION_TYPE[$model->connection_type] : null;
                },
                'filter' => C::LABEL_CONNECTION_TYPE,
            ],
            'actionOn',
            'actionBy',
        ];
    }

    public function advanceSearch() {
        return [
            ["label" => "Name", "attribute" => "name", "type" => "text"],
            ["label" => "Email", "attribute" => "email", "type" => "text"],
            ["label" => "Mobile No", "attribute" => "mobile_no", "type" => "text"],
            ["label" => "Phone No", "attribute" => "phone_no", "type" => "text"],
            ["label" => "Area", "attribute" => "area_name", "type" => "text"],
            ["label" => "Franchise", "attribute" => "operator_id", "type" => "dropdown", "list" => ArrayHelper::map(Operator::find()->defaultCondition()->andWhere(['type' => C::OPERATOR_TYPE_LCO])->asArray()->all(), "id", "name")],
            ["label" => "Stages", "attribute" => "stages", "type" => "dropdown", "list" => C::PROSPECT_SATGES],
        ];
    }

}
