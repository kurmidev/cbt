<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ott_master}}`.
 */
class m220421_062049_create_ott_master_table extends Migration {

    public $table = "ott_master";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull(),
            "code" => $this->string()->notNull(),
            "validity" => $this->integer()->notNull()->defaultValue(0),
            "status" => $this->integer()->defaultValue(common\ebl\Constants::STATUS_ACTIVE),
            "meta_data" => $this->json(),
            "description" => $this->string(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("IX-{$this->table}-name", $this->table, "name");
        $this->createIndex("IX-{$this->table}-code", $this->table, "code");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
