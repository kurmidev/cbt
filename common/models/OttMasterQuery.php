<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[OttPlanMaster]].
 *
 * @see OttPlanMaster
 */
class OttMasterQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return OttPlanMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OttPlanMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
