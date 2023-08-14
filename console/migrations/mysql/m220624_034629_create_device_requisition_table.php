<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%device_requisition}}`.
 */
class m220624_034629_create_device_requisition_table extends Migration {

    public $table = "device_requisition";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "company_id" => $this->integer()->notNull(),
            "name" => $this->string()->notNull(),
            "code" => $this->string()->unique()->notNull(),
            "description" => $this->string()->notNull(),
            "status" => $this->integer()->notNull(),
            "state" => $this->integer()->notNull()->defaultValue(0),
            "approval_meta_data" => $this->json(),
            "meta_data" => $this->json(),
            "approved_quantity" => $this->integer()->defaultValue(0),
            "purchased_quantity" => $this->integer()->defaultValue(0),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
        $this->createIndex("ix-{$this->table}-status", $this->table, "status");
        $this->createIndex("ix-{$this->table}-state", $this->table, "state");
        $this->addForeignKey("fk-{$this->table}-company_id", $this->table, "company_id", "operator", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
