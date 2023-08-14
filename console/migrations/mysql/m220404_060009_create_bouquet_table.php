<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bouquet}}`.
 */
class m220404_060009_create_bouquet_table extends Migration {

    public $table = "bouquet";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull(),
            "code" => $this->string()->unique(),
            "description" => $this->string(),
            "status" => $this->integer()->notNull(),
            "days"=> $this->integer()->notNull(),
            "free_days"=> $this->integer()->notNull(),
            "bill_type"=> $this->integer()->notNull(),
            "meta_data" => $this->json(),
            "is_online" => $this->integer()->notNull()->defaultValue(\common\ebl\Constants::STATUS_INACTIVE),
            "type" => $this->integer()->notNull(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("IX-{$this->table}-type", $this->table, ["type"]);
        $this->createIndex("IX-{$this->table}-status", $this->table, ["status"]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
        return true;
    }

}
