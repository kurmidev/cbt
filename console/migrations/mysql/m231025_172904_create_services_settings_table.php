<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%services_settings}}`.
 */
class m231025_172904_create_services_settings_table extends Migration
{
    protected $tableName = "services_settings";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "service_id"=> $this->integer()->notNull(), 
            "plugin_id" => $this->integer()->notNull(),
            "plugin_code"=> $this->string()->notNull(),
            "other_codes"=> $this->string(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey('fk-services-settings',$this->tableName,'service_id','services','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
