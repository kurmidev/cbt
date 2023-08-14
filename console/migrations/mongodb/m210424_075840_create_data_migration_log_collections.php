<?php

class m210424_075840_create_data_migration_log_collections extends \yii\mongodb\Migration {

    public $collection = "data_migration_log";

    public function up() {
        try {
            $this->dropCollection($this->collection);
        } catch (Exception $ex) {
            
        }
        $this->createCollection($this->collection, []);
        $this->createIndex($this->collection, ['status' => 1]);
        $this->createIndex($this->collection, ['type' => 1]);
    }

    public function down() {
        echo "m210424_075840_create_data_migration_log_collections cannot be reverted.\n";
        $this->dropAllIndexes($this->collection);
        $this->dropCollection($this->collection);
        return true;
    }

}
