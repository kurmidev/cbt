<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Complaint]].
 *
 * @see Complaint
 */
class ComplaintQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return Complaint[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Complaint|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
