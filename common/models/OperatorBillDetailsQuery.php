<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[OperatorBillDetails]].
 *
 * @see OperatorBillDetails
 */
class OperatorBillDetailsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return OperatorBillDetails[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OperatorBillDetails|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
