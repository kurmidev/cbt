<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[BouquetAssetMapping]].
 *
 * @see BouquetAssetMapping
 */
class BouquetAssetMappingQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return BouquetAssetMapping[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BouquetAssetMapping|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
