<?php

namespace common\models;

use common\ebl\Constants as C;

/**
 * This is the ActiveQuery class for [[VoucherMaster]].
 *
 * @see VoucherMaster
 */
class VoucherMasterQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return VoucherMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VoucherMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function active() {
        return $this->andWhere([$this->tableAlias . 'status' => C::VOUCHER_ACTIVE])
                ->andWhere(['opt_wallet_id'=>null,'cus_wallet_id'=>null]);
    }

}
