<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompCat]].
 *
 * @see CompCat
 */
class CompCatQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return CompCat[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CompCat|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function onlyParent($parent = true) {
        if ($parent) {
            return $this->andWhere(['parent_id' => 0]);
        } else {
            return $this->andWhere(['>', 'parent_id', 0]);
        }
    }

}
