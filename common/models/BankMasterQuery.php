<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[BankMaster]].
 *
 * @see BankMaster
 */
class BankMasterQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return BankMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BankMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
