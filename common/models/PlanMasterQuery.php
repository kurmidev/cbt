<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * This is the ActiveQuery class for [[PlanMaster]].
 *
 * @see PlanMaster
 */
class PlanMasterQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return PlanMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PlanMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function defaultCondition($alias = "") {
        $userType = User::loggedInUserType();
        $currentUserId = User::loggedInUserReferenceId();

        $c = new $this->modelClass();

        if (in_array($currentUserId, [C::USERTYPE_MSO])) {
            return $this;
        } elseif (in_array($userType, [C::USERTYPE_OPERATOR, C::USERTYPE_DISTRIBUTOR, C::USERTYPE_RO])) {
            $opt = Operator::find()->where(['OR', ['distributor_id' => $currentUserId], ['id' => $currentUserId], ['ro_id' => $currentUserId]])
                            ->indexBy('id')->asArray()->all();
            if (!empty($opt)) {
                return $this->innerJoinWith(['planAssoc p'])->andWhere(['p.operator_id' => array_keys($opt)]);
            }
        } else {
            $key = User::loggedInUserId();
            $op_id = Yii::$app->user->identity->getAssignedList();
            if (empty($op_id)) {
                return $this->innerJoinWith(['planAssoc p'])->andWhere(['p.operator_id' => $op_id]);
            }
        }

        return $this;
    }

}
