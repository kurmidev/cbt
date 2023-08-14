<?php

class m200521_114729_create_schedule_job_logs_collections extends \yii\mongodb\Migration {

    public $collection = "schedule_job_logs";

    public function up() {
        try {
            $this->dropCollection($this->collection);
        } catch (Exception $ex) {
            
        }
        $this->createCollection($this->collection, []);
        $this->createIndex($this->collection, ['type' => 1]);
    }

    public function down() {
        echo "m200521_114729_create_schedule_job_logs_collections cannot be reverted.\n";
        $this->dropCollection($this->collection);
        return true;
    }

}
