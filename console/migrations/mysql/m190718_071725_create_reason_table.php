<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reason}}`.
 */
class m190718_071725_create_reason_table extends common\ebl\migration\Migration {

    public $tableName = "reason";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull()->unique(),
            "code" => $this->string()->notNull()->unique(),
            "description" => $this->string(),
            "reason_for" => $this->json(),
            'status' => $this->smallInteger()->notNull()->defaultValue(\common\ebl\Constants::STATUS_ACTIVE),
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
        $this->dropTable($this->tableName);
    }

}
