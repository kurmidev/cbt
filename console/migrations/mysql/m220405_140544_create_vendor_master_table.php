<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vendor_master}}`.
 */
class m220405_140544_create_vendor_master_table extends Migration {

    public $table = "vendor_master";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull(),
            "code" => $this->string()->notNull(),
            "point_of_contact" => $this->string()->notNull(),
            "mobile_no" => $this->string()->notNull(),
            "email" => $this->string(),
            "address" => $this->string(),
            "pan_no" => $this->string(),
            "gst_no" => $this->string(),
            "status" => $this->integer(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
