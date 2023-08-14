<?php

namespace common\models;

use common\ebl\Constants as C;

/**
 * This is the ActiveQuery class for [[CustomerAccountBouquet]].
 *
 * @see CustomerAccountBouquet
 */
class CustomerAccountBouquetQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return CustomerAccountBouquet[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CustomerAccountBouquet|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function advanceRenewedAccount() {
        return $this->active()->andWhere(['>', $this->tableAlias . 'end_date', date("Y-m-d")])
                        ->andWhere([$this->tableAlias . 'bouquet_type' => C::PLAN_TYPE_BASE])
                        ->groupBy([$this->tableAlias . 'account_id'])->having("count(" . $this->tableAlias . "id)>1");
    }

}
