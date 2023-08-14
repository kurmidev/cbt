<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ConfigMaster]].
 *
 * @see ConfigMaster
 */
class ConfigMasterQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return ConfigMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ConfigMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
