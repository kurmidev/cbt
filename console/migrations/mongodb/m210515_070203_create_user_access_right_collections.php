<?php

class m210515_070203_create_user_access_right_collections extends \yii\mongodb\Migration {

    public $collection = "user_access_right";

    public function up() {
        try {
            $this->dropCollection($this->collection);
        } catch (Exception $ex) {
            
        }
        $this->createCollection($this->collection, []);
        $this->createIndex($this->collection, ['role_name' => 1]);
    }

    public function down() {
        echo "m210515_070203_create_user_access_right_collections cannot be reverted.\n";
        $this->dropCollection($this->collection);
        return true;
    }

}
