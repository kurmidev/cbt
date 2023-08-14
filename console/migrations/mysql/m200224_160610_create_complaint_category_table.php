<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%complaint_category}}`.
 */
class m200224_160610_create_complaint_category_table extends Migration {

    public $tableName = "comp_cat";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->unique()->notNull(),
            'parent_id' => $this->integer(),
            'description' => $this->string(),
            'status' => $this->integer(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("IX-$this->tableName-status", $this->tableName, ['status']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropIndex("IX-$this->tableName-status", $this->tableName);
        $this->dropTable($this->tableName);
    }

}
