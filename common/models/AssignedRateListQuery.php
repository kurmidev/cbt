<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AssignedRateList]].
 *
 * @see AssignedRateList
 */
class AssignedRateListQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return AssignedRateList[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AssignedRateList|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }


}
