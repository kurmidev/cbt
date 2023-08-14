<?php

class m210511_103922_create_notification_log_table extends \yii\mongodb\Migration {

    public $collection = "notification_log";

    public function up() {
        try {
            $this->dropCollection($this->collection);
        } catch (Exception $ex) {
            
        }
        $this->createCollection($this->collection, []);
        $this->createIndex($this->collection, ['type' => 1]);
        $this->createIndex($this->collection, ['account_id' => 1]);
        $this->createIndex($this->collection, ['operator_id' => 1]);
    }

    public function down() {
        echo "m210511_103922_create_notification_log_table cannot be reverted.\n";
        $this->dropAllIndexes($this->collection);
        $this->dropCollection($this->collection);
        return true;
    }

}
