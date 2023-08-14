<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%purchase_order}}`.
 */
class m220405_153805_create_purchase_order_table extends Migration {

    public $table = "purchase_order";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        try {
            $this->createTable($this->table, [
                'id' => $this->primaryKey(),
                "purchase_number" => $this->string()->notNull(),
                "purchase_date" => $this->date(),
                "invoice_number" => $this->string(),
                "invoice_date" => $this->date(),
                "vendor_id" => $this->integer()->notNull(),
                "device_id" => $this->integer()->notNull(),
                "quantity" => $this->integer(),
                "warranty_date" => $this->date(),
                'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
                'updated_on' => $this->dateTime()->null(),
                'added_by' => $this->integer(),
                'updated_by' => $this->integer()
            ]);
            $this->addForeignKey("FK-{$this->table}-vendor_id", $this->table, "vendor_id", 'vendor_master', 'id');
            $this->addForeignKey("FK-{$this->table}-device_id", $this->table, "device_id", 'device_master', 'id');
        } catch (Exception $ex) {
            
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
