<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProspectReply]].
 *
 * @see ProspectReply
 */
class ProspectReplyQuery extends \common\models\BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return ProspectReply[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProspectReply|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
