<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%device_requisition_items}}`.
 */
class m220624_035452_create_device_requisition_items_table extends Migration {

    public $table = "device_requisition_items";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'requisition_id' => $this->integer()->notNull(),
            "vendor_id" => $this->integer()->notNull(),
            "device_id" => $this->integer()->notNull(),
            "req_quantity" => $this->integer()->notNull(),
            "app_quantity" => $this->integer(),
            "meta_data" => $this->json(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey("fk-{$this->table}-requisition_id", $this->table, 'requisition_id', 'device_requisition', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
