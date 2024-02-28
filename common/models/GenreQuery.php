<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Genre]].
 *
 * @see Genre
 */
class GenreQuery extends BaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Genre[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Genre|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
