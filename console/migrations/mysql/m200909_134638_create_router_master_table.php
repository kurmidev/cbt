<?php

use common\ebl\migration\Migration;

/**
 * Handles the creation of table `{{%router_master}}`.
 */
class m200909_134638_create_router_master_table extends Migration {

    public $table = "router_master";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        try {
            $this->createTable($this->table, [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'code' => $this->string()->notNull(),
                'status' => $this->integer(),
                'nas_type' => $this->string(),
                'setting' => $this->json(),
                'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
                'updated_on' => $this->dateTime()->null(),
                'added_by' => $this->integer(),
                'updated_by' => $this->integer()
            ]);
        } catch (Exception $ex) {
            
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
