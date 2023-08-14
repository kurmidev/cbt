<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bank_master}}`.
 */
class m200221_164323_create_bank_master_table extends Migration {

    public $tableName = "bank_master";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->string()->unique()->notNull(),
            'address' => $this->string(),
            'branch' => $this->string(),
            'status' => $this->integer(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
        return TRUE;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->tableName);
        return true;
    }

}
