<?php

use common\ebl\migration\Migration;

/**
 * Handles the creation of table `{{%operator_rates}}`.
 */
class m200715_071012_create_operator_rates_table extends Migration {

    public $table = "operator_rates";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'operator_id' => $this->integer()->notNull(),
            'assoc_id' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'rate_id' => $this->integer()->notNull(),
            'amount' => $this->money()->notNull(),
            'tax' => $this->money()->notNull(),
            'mrp' => $this->money()->notNull(),
            'mrp_tax' => $this->money()->notNull(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("UIX-{$this->table}-operator_id-assoc_id-rate_id-type", $this->table, ['rate_id', 'operator_id', 'assoc_id', 'type'], 1);
        $this->createIndex("IX-{$this->table}-operator_id", $this->table, ['operator_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
