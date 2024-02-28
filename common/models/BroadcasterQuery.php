<?php

namespace common\models;

use common\models\BaseQuery;

/**
 * This is the ActiveQuery class for [[Broadcaster]].
 *
 * @see Broadcaster
 */
class BroadcasterQuery extends BaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Broadcaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Broadcaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
