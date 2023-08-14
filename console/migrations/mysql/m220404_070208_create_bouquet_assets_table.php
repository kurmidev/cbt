<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bouquet_assets}}`.
 */
class m220404_070208_create_bouquet_assets_table extends Migration {

    public $table = "bouquet_assets";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull(),
            "code" => $this->string()->notNull(),
            "type" => $this->integer()->notNull(),
            "price" => $this->money(),
            "status" => $this->integer()->notNull(),
            "mapped_id" => $this->integer()->notNull(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
        $this->createIndex("IX-{$this->table}-type", $this->table, "type");
        $this->createIndex("IX-{$this->table}-mapped_id", $this->table, "mapped_id");
        $this->createIndex("IX-{$this->table}-status", $this->table, "status");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
        return true;
    }

}
