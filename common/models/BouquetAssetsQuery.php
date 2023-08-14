<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[BouquetAssets]].
 *
 * @see BouquetAssets
 */
class BouquetAssetsQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return BouquetAssets[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BouquetAssets|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
