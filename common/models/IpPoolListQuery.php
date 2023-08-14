<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[IpPoolList]].
 *
 * @see IpPoolList
 */
class IpPoolListQuery extends \common\models\BaseQuery {

    /**
     * @inheritdoc
     * @return IpPoolList[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return IpPoolList|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function freeIps() {
        return $this->andWhere(['account_id' => null]);
    }

    public function allotedips() {
        return $this->andWhere(['not', ['account_id' => null]]);
    }

}
