<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Configuration]].
 *
 * @see Configuration
 */
class ConfigurationQuery extends \common\models\BaseQuery {

    /**
     * @inheritdoc
     * @return Configuration[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Configuration|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
