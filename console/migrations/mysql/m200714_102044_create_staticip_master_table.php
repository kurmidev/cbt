<?php

use common\ebl\migration\Migration;

/**
 * Handles the creation of table `{{%staticip_master}}`.
 */
class m200714_102044_create_staticip_master_table extends Migration {

    public $table = "staticip_master";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "name" => $this->string()->unique()->notNull(),
            "code" => $this->string()->unique()->notNull(),
            'status' => $this->integer(),
            'days'=> $this->integer(),
            "description" => $this->string(),
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
