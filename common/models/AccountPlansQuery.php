<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AccountPlans]].
 *
 * @see AccountPlans
 */
class AccountPlansQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return AccountPlans[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AccountPlans|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
