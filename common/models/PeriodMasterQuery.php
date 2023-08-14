<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PeriodMaster]].
 *
 * @see PeriodMaster
 */
class PeriodMasterQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return PeriodMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PeriodMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
