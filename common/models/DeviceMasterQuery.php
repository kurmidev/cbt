<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[DeviceMaster]].
 *
 * @see DeviceMaster
 */
class DeviceMasterQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return DeviceMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DeviceMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
