<?php

use common\ebl\migration\Migration;

/**
 * Handles the creation of table `{{%rate_master}}`.
 */
class m200707_081639_create_rate_master_table extends Migration {

    public $table = "rate_master";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->dropTableIfExists($this->table);

        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull(),
            "type" => $this->integer()->notNull(),
            "assoc_id" => $this->integer()->notNull(),
            "amount" => $this->money(),
            "tax" => $this->money(),
            "mrp" => $this->money(),
            "mrp_tax" => $this->money(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("IX-$this->table-assoc_id", $this->table, 'assoc_id');
        $this->createIndex("IX-$this->table-type", $this->table, 'type');
        $this->createIndex("IX-$this->table-assoc_id-type", $this->table, ['assoc_id', 'type']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
