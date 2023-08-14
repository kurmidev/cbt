<?php

class m200221_160159_create_code_sequence_collection extends \yii\mongodb\Migration {

    public $collection = "code_sequence";

    public function up() {
        try {
            $this->dropCollection($this->collection);
        } catch (Exception $ex) {
            
        }
        $this->createCollection($this->collection, []);
        $this->createIndex($this->collection, ['prefix' => 1]);
    }

    public function down() {
        echo "m200221_160159_create_code_sequence_collection cannot be reverted.\n";
        $this->dropCollection($this->collection);
        return TRUE;
    }

}
