<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%nas}}`.
 */
class m200226_155918_create_nas_table extends Migration {

    public $tableName = "nas";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'ip_address' => $this->string()->unique(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->unique(),
            'ports' => $this->integer(),
            'type' => $this->string(),
            'secret' => $this->string()->notNull(),
            'description' => $this->string(),
            'meta_data' => $this->json(),
            'status' => $this->integer(),
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
        $this->dropTable($this->tableName);
    }

}
