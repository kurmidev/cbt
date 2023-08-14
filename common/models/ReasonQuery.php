<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Reason]].
 *
 * @see Reason
 */
class ReasonQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return Reason[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Reason|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
