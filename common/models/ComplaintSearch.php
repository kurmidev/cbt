<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Complaint;
use common\ebl\Constants as C;
use yii\helpers\ArrayHelper;

/**
 * ComplaintSearch represents the model behind the search form of `common\models\Complaint`.
 */
class ComplaintSearch extends Complaint {

    public $customer_name;
    public $mobile_no;
    public $email;
    public $distributor_id;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'operator_id', 'account_id', 'customer_id', 'category_id', 'status', 'stages', 'current_assigned', 'added_by', 'updated_by'], 'integer'],
            [['ticketno', 'username', 'opening', 'closing', 'assigned_to', 'extra_details', 'opening_date', 'closing_date', 'nextfollowup', 'added_on', 'updated_on', 'customer_name', 'email', 'mobile_no', 'distributor_id'], 'safe'],
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
        $query = Complaint::find();

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

        if (!empty($this->customer_name) || !empty($this->mobile_no) || !empty($this->email)) {
            $query->joinWith(['customer s'])->andFilterWhere(['like', 's.name', $this->customer_name])
                    ->andFilterWhere(['like', 's.mobile_no', $this->mobile_no])
                    ->andFilterWhere(['like', 's.email', $this->email]);
        }

        if (!empty($this->distributor_id)) {
            $query->joinWith(['operator o'])->andFilterWhere(['o.distributor_id' => $this->distributor_id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'operator_id' => $this->operator_id,
            'account_id' => $this->account_id,
            'customer_id' => $this->customer_id,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'stages' => $this->stages,
            'current_assigned' => $this->current_assigned,
            'opening_date' => $this->opening_date,
            'closing_date' => $this->closing_date,
            'nextfollowup' => $this->nextfollowup,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'ticketno', $this->ticketno])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'opening', $this->opening])
                ->andFilterWhere(['like', 'closing', $this->closing])
                ->andFilterWhere(['like', 'assigned_to', $this->assigned_to])
                ->andFilterWhere(['like', 'extra_details', $this->extra_details]);

        return $dataProvider;
    }

    public function displayColumn($type = "") {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            "ticketno:text:Ticket No",
            "username:text:Username",
            "customer.name:text:Name",
            "customer.cid:text:CID",
            "operator.name:text:Franchise",
            "operator.code:text:Franchise Code",
            "operator.distributor.name:text:Distributor",
            "operator.distributor.code:text:Distributor Code",
            "category.name:text:Category",
            "opening:text:Opening Remark",
            "closing:text:Closing Remark",
            "opening_date:date:Opening Date",
            "closing_date:date:Closing Date",
            ['attribute' => 'stages', 'label' => 'Status',
                'content' => function ($model) {
                    return !empty(C::COMPLAINT_SATGES[$model->stages]) ? C::COMPLAINT_SATGES[$model->stages] : "";
                },
            ],
            'actionOn',
            'actionBy',
        ];
    }

    public function advanceSearch($type = "") {
        return [
            ["label" => "Name", "attribute" => "customer_name", "type" => "text"],
            ["label" => "username", "attribute" => "username", "type" => "text"],
            ["label" => "Mobile No", "attribute" => "mobile_no", "type" => "text"],
            ["label" => "Franchise", "attribute" => "operator_id", "type" => "dropdown", "list" => ArrayHelper::map(Operator::find()->defaultCondition()->andWhere(['type' => C::OPERATOR_TYPE_LCO])->asArray()->all(), "id", "name")],
            ["label" => "Distributor", "attribute" => "distributor_id", "type" => "dropdown", "list" => ArrayHelper::map(Operator::find()->defaultCondition()->andWhere(['type' => C::OPERATOR_TYPE_DISTRIBUTOR])->asArray()->all(), "id", "name")],
            ["label" => "Stages", "attribute" => "stages", "type" => "dropdown", "list" => C::COMPLAINT_SATGES],
        ];
    }

}
