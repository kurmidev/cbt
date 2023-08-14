<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Nas]].
 *
 * @see Nas
 */
class NasQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return Nas[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Nas|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
