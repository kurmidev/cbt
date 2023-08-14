<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%plan_master}}`.
 */
class m190801_095800_create_plan_master_table extends common\ebl\migration\Migration {

    public $tableName = 'plan_master';

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull(),
            "code" => $this->string()->unique()->notNull(),
            "display_name" => $this->string(),
            "is_exclusive" => $this->integer()->notNull()->defaultValue(0),
            "is_promotional" => $this->integer()->notNull()->defaultValue(0),
            "plan_type" => $this->integer()->notNull(),
            "billing_type" => $this->integer()->notNull(),
            "status" => $this->integer()->notNull(),
            "days" => $this->integer()->notNull(),
            "free_days" => $this->integer()->null(),
            "reset_type" => $this->integer()->notNull(),
            "reset_value" => $this->money()->notNull(),
            "upload" => $this->money(),
            "download" => $this->money(),
            "applicable_days" => $this->json(),
            "post_upload" => $this->money(),
            "post_download" => $this->money(),
            "limit_type" => $this->integer()->notNull(),
            "limit_value" => $this->money()->notNull(),
            "description" => $this->string(),
            "meta_data" => $this->json(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("IX-$this->tableName-is_exclusive", $this->tableName, 'is_exclusive');
        $this->createIndex("IX-$this->tableName-is_promotional", $this->tableName, 'is_promotional');
        $this->createIndex("IX-$this->tableName-plan_type", $this->tableName, 'plan_type');
        $this->createIndex("IX-$this->tableName-status", $this->tableName, 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->tableName);
    }

}
