<?php

class m220430_134042_create_device_inventory_tracking_collection extends \yii\mongodb\Migration {

    public $collection = "device_inventory_tracking";

    public function up() {
        try {
            $this->dropCollection($this->collection);
        } catch (Exception $ex) {
            
        }
        $this->createCollection($this->collection, []);
        $this->createIndex($this->collection, ['serial_no' => 1]);
        $this->createIndex($this->collection, ['operator_id' => 1]);
        $this->createIndex($this->collection, ['activity_done' => 1]);
        $this->createIndex($this->collection, ['activity_date' => 1]);
    }

    public function down() {
        echo "m220430_134042_create_device_inventory_tracking_collection cannot be reverted.\n";

        return true;
    }

}
