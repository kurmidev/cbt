<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_assignment}}`.
 */
class m210420_084012_create_user_assignment_table extends Migration {

    public $table = "user_assignment";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "user_id" => $this->integer(),
            "assigned_id" => $this->integer(),
            "type" => $this->integer(),
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
