<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MultiRateList]].
 *
 * @see MultiRateList
 */
class MultiRateListQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return MultiRateList[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MultiRateList|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
