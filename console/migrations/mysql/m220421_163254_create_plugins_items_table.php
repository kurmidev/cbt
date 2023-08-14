<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%plugins_items}}`.
 */
class m220421_163254_create_plugins_items_table extends Migration {

    public $table = "plugins_items";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "plugin_id" => $this->integer()->notNull(),
            "name" => $this->string()->notNull(),
            "value" => $this->string()->notNull(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey("FK-{$this->table}-plugin_id", $this->table, "plugin_id", "plugins_master", "id", 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
