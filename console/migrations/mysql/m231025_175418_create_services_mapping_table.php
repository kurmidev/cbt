<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%services_mapping}}`.
 */
class m231025_175418_create_services_mapping_table extends Migration
{
    protected $tableName = "services_mapping";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "service_id"=> $this->integer()->notNull(),
            "parent_id"=> $this->integer()->notNull(),
            "child_id"=> $this->integer()->notNull(), 
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey('fk-services-parent_id',$this->tableName,'parent_id','services','id');
        $this->addForeignKey('fk-services-child_id',$this->tableName,'child_id','services','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
