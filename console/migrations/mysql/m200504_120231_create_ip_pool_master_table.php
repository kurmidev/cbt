<?php

use common\ebl\migration\Migration;

/**
 * Handles the creation of table `{{%ip_pool_master}}`.
 */
class m200504_120231_create_ip_pool_master_table extends Migration {

    public $table = "ip_pool_master";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'ipaddress' => $this->string()->notNull(),
            'type' => $this->tinyInteger()->notNull(),
            'plugin_id' => $this->integer()->notNull(),
            'status' => $this->tinyInteger()->notNull(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndexIfNotExist("uix-$this->table-ip_address_type_plugin_id", $this->table, ['ipaddress', 'plugin_id'],1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropAllForeignKeyIfExist($this->table);
        $this->dropTable($this->table);
    }

}
