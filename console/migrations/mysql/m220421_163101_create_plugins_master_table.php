<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%plugins_master}}`.
 */
class m220421_163101_create_plugins_master_table extends Migration {

    public $table = "plugins_master";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull(),
            "plugin_type" => $this->integer()->notNull(),
            "plugin_url" => $this->string()->notNull(),
            "meta_data" => $this->json(),
            "description" => $this->string(),
            "status" => $this->integer()->notNull()->defaultValue(common\ebl\Constants::STATUS_ACTIVE),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("IX-{$this->table}-status", $this->table, "status");
        $this->createIndex("IX-{$this->table}-plugin_type", $this->table, "plugin_type");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
