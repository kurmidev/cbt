<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PluginsMaster]].
 *
 * @see PluginsMaster
 */
class PluginsMasterQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return PluginsMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PluginsMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
