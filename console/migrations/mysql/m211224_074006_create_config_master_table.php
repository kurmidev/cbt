<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%config_master}}`.
 */
class m211224_074006_create_config_master_table extends Migration {

    public $table = "config_master";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "name" => $this->string(),
            "type" => $this->string(),
            "config" => $this->json(),
            "status" => $this->integer(),
            "added_on" => $this->dateTime(),
            "added_by" => $this->integer(),
            "modified_on" => $this->dateTime(),
            "modified_by" => $this->integer()
        ]);

        $this->createIndex("IX-{$this->table}-type", $this->table, 'type');
        $this->createIndex("IX-{$this->table}-status", $this->table, 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
