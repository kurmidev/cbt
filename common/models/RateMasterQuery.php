<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[RateMaster]].
 *
 * @see RateMaster
 */
class RateMasterQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return RateMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RateMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
