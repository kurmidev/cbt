<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Language]].
 *
 * @see Language
 */
class LanguageQuery extends BaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Language[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Language|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
