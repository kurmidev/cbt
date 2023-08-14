<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[DeviceInventory]].
 *
 * @see DeviceInventory
 */
class DeviceInventoryQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return DeviceInventory[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DeviceInventory|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
