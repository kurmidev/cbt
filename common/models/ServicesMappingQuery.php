<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ServicesMapping]].
 *
 * @see ServicesMapping
 */
class ServicesMappingQuery extends \common\models\BaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ServicesMapping[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ServicesMapping|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
