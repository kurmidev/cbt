<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[IpPoolMaster]].
 *
 * @see IpPoolMaster
 */
class IpPoolMasterQuery extends \common\models\BaseQuery {

    /**
     * @inheritdoc
     * @return IpPoolMaster[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return IpPoolMaster|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
