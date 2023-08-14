<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%radius_reply}}`.
 */
class m210205_174652_create_radius_reply_table extends Migration {

    public $table = "radius_reply";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "account_id" => $this->bigInteger(),
            "username" => $this->string()->notNull(),
            "attribute" => $this->string()->notNull(),
            "op" => $this->string()->notNull()->defaultValue("=="),
            "value" => $this->string()->notNull(),
            "start_time" => $this->time(),
            "end_time" => $this->time()
        ]);
        $this->createIndex("ix-username", $this->table, ['username']);
        $this->addForeignKey("fk-{$this->table}-account_id", $this->table, "account_id", "customer_account", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
