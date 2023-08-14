<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RadiusAccounting;

/**
 * RadiusAccountingSearch represents the model behind the search form of `common\models\RadiusAccounting`.
 */
class RadiusAccountingSearch extends RadiusAccounting {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'acctinterval', 'acctsessiontime', 'acctinputoctets', 'acctoutputoctets'], 'integer'],
            [['acctsessionid', 'acctuniqueid', 'username', 'realm', 'nasipaddress', 'nasportid', 'nasporttype', 'acctstarttime', 'acctupdatetime', 'acctstoptime', 'acctauthentic', 'connectinfo_start', 'connectinfo_stop', 'calledstationid', 'callingstationid', 'acctterminatecause', 'servicetype', 'framedprotocol', 'framedipaddress', 'framedipv6address', 'framedipv6prefix', 'framedinterfaceid', 'delegatedipv6prefix'], 'safe'],
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
        $query = RadiusAccounting::find();

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
            'acctstarttime' => $this->acctstarttime,
            'acctupdatetime' => $this->acctupdatetime,
            'acctstoptime' => $this->acctstoptime,
            'acctinterval' => $this->acctinterval,
            'acctsessiontime' => $this->acctsessiontime,
            'acctinputoctets' => $this->acctinputoctets,
            'acctoutputoctets' => $this->acctoutputoctets,
        ]);

        $query->andFilterWhere(['like', 'acctsessionid', $this->acctsessionid])
                ->andFilterWhere(['like', 'acctuniqueid', $this->acctuniqueid])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'realm', $this->realm])
                ->andFilterWhere(['like', 'nasipaddress', $this->nasipaddress])
                ->andFilterWhere(['like', 'nasportid', $this->nasportid])
                ->andFilterWhere(['like', 'nasporttype', $this->nasporttype])
                ->andFilterWhere(['like', 'acctauthentic', $this->acctauthentic])
                ->andFilterWhere(['like', 'connectinfo_start', $this->connectinfo_start])
                ->andFilterWhere(['like', 'connectinfo_stop', $this->connectinfo_stop])
                ->andFilterWhere(['like', 'calledstationid', $this->calledstationid])
                ->andFilterWhere(['like', 'callingstationid', $this->callingstationid])
                ->andFilterWhere(['like', 'acctterminatecause', $this->acctterminatecause])
                ->andFilterWhere(['like', 'servicetype', $this->servicetype])
                ->andFilterWhere(['like', 'framedprotocol', $this->framedprotocol])
                ->andFilterWhere(['like', 'framedipaddress', $this->framedipaddress])
                ->andFilterWhere(['like', 'framedipv6address', $this->framedipv6address])
                ->andFilterWhere(['like', 'framedipv6prefix', $this->framedipv6prefix])
                ->andFilterWhere(['like', 'framedinterfaceid', $this->framedinterfaceid])
                ->andFilterWhere(['like', 'delegatedipv6prefix', $this->delegatedipv6prefix]);

        return $dataProvider;
    }

}
