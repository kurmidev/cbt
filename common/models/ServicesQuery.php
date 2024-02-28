<?php

namespace common\models;

use common\models\BaseQuery;

/**
 * This is the ActiveQuery class for [[Services]].
 *
 * @see Services
 */
class ServicesQuery extends BaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Services[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Services|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
