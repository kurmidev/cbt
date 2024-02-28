<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%broadcaster}}`.
 */
class m231025_165949_create_broadcaster_table extends Migration
{
    protected $tableName = "broadcaster";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name'=> $this->string()->notNull(),
            'code'=> $this->string()->notNull(),
            'contact_no'=>$this->string()->notNull(),
            'address'=> $this->string(),
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
        $this->dropTable($this->broadcaster);
    }
}
