<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Bouquet]].
 *
 * @see Bouquet
 */
class BouquetQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return Bouquet[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Bouquet|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
