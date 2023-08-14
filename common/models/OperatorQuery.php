<?php

namespace common\models;

use common\ebl\Constants as C;
use Yii;

/**
 * This is the ActiveQuery class for [[Operator]].
 *
 * @see Operator
 */
class OperatorQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return Operator[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Operator|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function excludeSysDef() {
        return $this->andWhere(['not', ['type' => [C::USERTYPE_MSO, C::USERTYPE_ADMIN]]]);
    }

    public function isDistributor() {
        return $this->andWhere(['type' => C::OPERATOR_TYPE_DISTRIBUTOR]);
    }

    public function isFranchise() {
        return $this->andWhere(['type' => C::OPERATOR_TYPE_LCO]);
    }

    public function defaultCondition($alias = "") {
        $this->tableAlias = $alias;
        $userType = User::loggedInUserType();
        $currentUserId = User::loggedInUserReferenceId();
        
        if ($userType <= C::USERTYPE_MSO) {
            return $this;
        } elseif (in_array($userType, [C::USERTYPE_RO, C::USERTYPE_OPERATOR, C::USERTYPE_DISTRIBUTOR])) {
            $opt = Operator::find()->where(['OR', ['ro_id' => $currentUserId], ['distributor_id' => $currentUserId], ['id' => $currentUserId]])
                            ->indexBy('id')->asArray()->all();
            if (!empty($opt)) {
                return $this->andWhere([$this->tableAlias . 'id' => array_keys($opt)]);
            }
        } else {
            $key = User::loggedInUserId();
            $op_id = Yii::$app->user->identity->getAssignedList();
            if (empty($op_id)) {
                return $this->andWhere([$this->tableAlias . 'id' => $op_id]);
            }
        }
        return $this;
    }

}
