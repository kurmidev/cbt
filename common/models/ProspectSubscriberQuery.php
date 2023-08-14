<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProspectSubscriber]].
 *
 * @see ProspectSubscriber
 */
class ProspectSubscriberQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return ProspectSubscriber[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProspectSubscriber|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
