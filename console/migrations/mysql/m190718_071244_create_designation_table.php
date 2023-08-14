<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%designation}}`.
 */
class m190718_071244_create_designation_table extends common\ebl\migration\Migration {

    public $tableName = "designation";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull()->unique(),
            "code" => $this->string()->notNull()->unique(),
            "parent_id" => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(\common\ebl\Constants::STATUS_ACTIVE),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
        $this->createIndex(
                'idx-' . $this->tableName . '-status', $this->tableName, ['status']
        );
        $this->createIndex(
                'idx-' . $this->tableName . '-name', $this->tableName, ['name'],1
        );
        $this->createIndex(
                'idx-' . $this->tableName . '-code', $this->tableName, ['code'],1
        );
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropIndex('idx-' . $this->tableName . '-status', $this->tableName);
        $this->dropIndex('idx-' . $this->tableName . '-name', $this->tableName);
        $this->dropIndex('idx-' . $this->tableName . '-code', $this->tableName);
        $this->dropTable($this->tableName);
    }

}
