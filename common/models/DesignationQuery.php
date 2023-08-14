<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Designation]].
 *
 * @see Designation
 */
class DesignationQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return Designation[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Designation|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
