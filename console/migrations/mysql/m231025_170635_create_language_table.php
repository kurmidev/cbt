<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%language}}`.
 */
class m231025_170635_create_language_table extends Migration
{
    protected $tableName = "language";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "name"=> $this->string()->notNull()->unique(),
            "code"=> $this->string()->notNull()->unique(),
            'status'=> $this->integer()->notNull(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
