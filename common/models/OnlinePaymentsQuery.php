<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[OnlinePayments]].
 *
 * @see OnlinePayments
 */
class OnlinePaymentsQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return OnlinePayments[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OnlinePayments|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
