<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%radius_post_auth}}`.
 */
class m210205_175415_create_radius_post_auth_table extends Migration {

    public $table = "radius_post_auth";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "username" => $this->string()->notNull(),
            "pass" => $this->string(),
            "reply" => $this->string(),
            "authdate" => $this->dateTime()->defaultExpression("now()")
        ]);
        $this->createIndex("ix-username", $this->table, ["username"]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
