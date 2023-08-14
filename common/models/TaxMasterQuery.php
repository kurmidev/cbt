<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[TaxMaster]].
 *
 * @see TaxMaster
 */
class TaxMasterQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return TaxMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TaxMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
