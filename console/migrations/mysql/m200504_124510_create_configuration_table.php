<?php

use common\ebl\migration\Migration;

/**
 * Handles the creation of table `{{%configuration}}`.
 */
class m200504_124510_create_configuration_table extends Migration {

    public $table = "configuration";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'config_for' => $this->integer(),
            'attribute' => $this->string()->notNull(),
            'op' => $this->string()->null(),
            'value' => $this->string()->notNull(),
            'status' => $this->tinyInteger()->notNull(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("ix-$this->table-type", $this->table, 'type');
        $this->createIndex("ix-$this->table-config_for", $this->table, 'config_for');
        $this->createIndex("ix-$this->table-attribute", $this->table, 'attribute');
        $this->createIndex("ix-$this->table-status", $this->table, 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
