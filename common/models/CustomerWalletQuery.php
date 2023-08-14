<?php

namespace common\models;

use common\ebl\Constants as C;
/**
 * This is the ActiveQuery class for [[WalletTransaction]].
 *
 * @see WalletTransaction
 */
class CustomerWalletQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return WalletTransaction[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return WalletTransaction|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
    
    public function collectionEntry(){
        return $this->andWhere(['trans_type'=>C::TRANSACTION_TYPE_SUB_COLLECTION]);
    }
    
    public function debitEntry(){
        return $this->andWhere(['trans_type'=>C::TRANSACTION_TYPE_SUB_DEBIT]);
    }
    
    public function creditEntry(){
        return $this->andWhere(['trans_type'=>C::TRANSACTION_TYPE_SUB_CREDIT]);
    }
    
}
