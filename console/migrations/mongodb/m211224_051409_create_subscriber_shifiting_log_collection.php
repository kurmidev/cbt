<?php

class m211224_051409_create_subscriber_shifiting_log_collection extends \yii\mongodb\Migration {

    public $collection = "subscriber_shifting_log";

    public function up() {
        try {
            $this->dropCollection($this->collection);
        } catch (Exception $ex) {
            
        }
        $this->createCollection($this->collection, []);
        $this->createIndex($this->collection, ['account_id' => 1]);
        $this->createIndex($this->collection, ['customer_id' => 1]);
        $this->createIndex($this->collection, ['from_operator_id' => 1]);
        $this->createIndex($this->collection, ['to_operator_id' => 1]);
    }

    public function down() {
        echo "m211224_051409_create_subscriber_shifiting_log_collection cannot be reverted.\n";

        return false;
    }

}
