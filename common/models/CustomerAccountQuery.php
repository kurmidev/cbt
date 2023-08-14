<?php

namespace common\models;

use common\ebl\Constants as C;

/**
 * This is the ActiveQuery class for [[CustomerAccount]].
 *
 * @see CustomerAccount
 */
class CustomerAccountQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return CustomerAccount[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CustomerAccount|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function needtoRenew() {
        $query = CustomerAccountBouquet::find()->select(['account_id'])
                ->advanceRenewedAccount();
        return $this->andWhere(['OR', [' not in ', $this->tableAlias . 'id', $query], [$this->tableAlias . 'status' => C::STATUS_EXPIRED]]);
    }

}
