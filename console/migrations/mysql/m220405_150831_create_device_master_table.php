<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%device_master}}`.
 */
class m220405_150831_create_device_master_table extends Migration {

    public $table = "device_master";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull(),
            "code" => $this->string()->notNull()->unique(),
            "vendor_id" => $this->integer()->notNull(),
            "description" => $this->string(),
            "status" => $this->integer()->notNull(),
            "amount" => $this->money(),
            "tax" => $this->money(),
            "units" => $this->integer()->notNull(),
            "device_attributes" => $this->json(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
        $this->addForeignKey("FK-{$this->table}-vendor_id", $this->table, "vendor_id", 'vendor_master', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
