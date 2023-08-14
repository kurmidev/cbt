<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ComplaintDetails]].
 *
 * @see ComplaintDetails
 */
class ComplaintDetailsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return ComplaintDetails[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComplaintDetails|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
