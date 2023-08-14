<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[OperatorPlanRates]].
 *
 * @see OperatorPlanRates
 */
class OperatorRatesQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return OperatorPlanRates[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OperatorPlanRates|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function active() {
        return $this->joinWith(['bouquet b'])->andWhere(['b.status' => \common\ebl\Constants::STATUS_ACTIVE]);
    }

    public function onlyBase() {
        return $this->joinWith(['bouquet b'])->andWhere(['b.status' => \common\ebl\Constants::STATUS_ACTIVE,"b.type"=> \common\ebl\Constants::PLAN_TYPE_BASE]);
    }

    public function onlyAddons() {
        return $this->joinWith(['bouquet b'])->andWhere(['b.status' => \common\ebl\Constants::STATUS_ACTIVE,"b.type"=> \common\ebl\Constants::PLAN_TYPE_ADDONS]);
    }

}
