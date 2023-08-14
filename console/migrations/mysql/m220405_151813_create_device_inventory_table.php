<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%device_inventory}}`.
 */
class m220405_151813_create_device_inventory_table extends Migration {

    public $table = "device_inventory";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey(),
            "vendor_id" => $this->integer()->notNull(),
            "device_id" => $this->integer()->notNull(),
            "warranty_date" => $this->date(),
            "operator_id" => $this->integer()->notNull(),
            "account_id" => $this->bigInteger(),
            "serial_no" => $this->string()->unique()->notNull(),
            "meta_data" => $this->json(),
            "purchase_order_id" => $this->integer(),
            "operator_scheme" => $this->json(),
            "customer_scheme" => $this->json(),
            "locked_at" => $this->integer(),
            "locked_token" => $this->string(),
            "status" => $this->integer()->notNull(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
        $this->addForeignKey("FK-{$this->table}-vendor_id", $this->table, "vendor_id", 'vendor_master', 'id');
        $this->addForeignKey("FK-{$this->table}-device_id", $this->table, "device_id", 'device_master', 'id');
        $this->addForeignKey("FK-{$this->table}-operator_id", $this->table, "operator_id", 'operator', 'id');
        $this->createIndex("IX-{$this->table}-purchase_order_id", $this->table, "purchase_order_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
