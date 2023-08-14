<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[OperatorBill]].
 *
 * @see OperatorBill
 */
class OperatorBillQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return OperatorBill[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OperatorBill|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
