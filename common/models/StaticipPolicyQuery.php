<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[StaticipPolicy]].
 *
 * @see StaticipPolicy
 */
class StaticipPolicyQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return StaticipPolicy[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaticipPolicy|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
