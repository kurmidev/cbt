<?php

class m200406_161736_create_upload_documents_collections extends \yii\mongodb\Migration {

    public $collection = "upload_documents";

    public function up() {
        try {
            $this->dropCollection($this->collection);
        } catch (Exception $ex) {
            
        }
        $this->createCollection($this->collection, []);
        $this->createIndex($this->collection, ['type' => 1]);
        $this->createIndex($this->collection, ['model_id' => 1]);
    }

    public function down() {
        echo "m200406_161736_create_upload_documents_collections cannot be reverted.\n";
        $this->dropCollection($this->collection);
        return true;
    }

}
