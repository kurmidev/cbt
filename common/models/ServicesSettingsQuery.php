<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ServicesSettings]].
 *
 * @see ServicesSettings
 */
class ServicesSettingsQuery extends \common\models\BaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ServicesSettings[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ServicesSettings|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
