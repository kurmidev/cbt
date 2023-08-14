<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[RouterMaster]].
 *
 * @see RouterMaster
 */
class RouterMasterQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return RouterMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RouterMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
