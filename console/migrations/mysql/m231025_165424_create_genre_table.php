<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%genre}}`.
 */
class m231025_165424_create_genre_table extends Migration
{
    protected $tableName = "genre";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name'=> $this->string()->notNull()->unique(),
            'code'=> $this->string()->notNull()->unique(),
            'description'=> $this->string()->notNull(), 
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
