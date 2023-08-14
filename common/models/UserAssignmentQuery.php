<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[UserAssignment]].
 *
 * @see UserAssignment
 */
class UserAssignmentQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return UserAssignment[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserAssignment|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
