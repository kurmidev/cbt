<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[StaticipMaster]].
 *
 * @see StaticipMaster
 */
class StaticipMasterQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return StaticipMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaticipMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
