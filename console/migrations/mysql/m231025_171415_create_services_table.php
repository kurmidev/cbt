<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%services}}`.
 */
class m231025_171415_create_services_table extends Migration
{
    protected $tableName = "services";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "name"=> $this->string()->notNull(),
            "code"=>$this->string()->notNull()->unique(),
            "service_type"=> $this->integer()->notNull(),
            "type"=>$this->integer()->notNull(),
            "broadcaster_id"=> $this->integer(),
            "language_id"=> $this->integer(),
            "genre_id"=> $this->integer(),
            "is_alacarte"=> $this->integer(),
            "is_fta"=> $this->integer(),
            "rate" => $this->money()->notNull(),
            "description" => $this->string(),
            "meta_data" => $this->json(),
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
