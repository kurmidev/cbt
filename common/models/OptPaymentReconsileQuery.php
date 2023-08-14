<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[OptPaymentReconsile]].
 *
 * @see OptPaymentReconsile
 */
class OptPaymentReconsileQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return OptPaymentReconsile[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OptPaymentReconsile|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
