<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_tat}}`.
 */
class m200907_103316_create_user_tat_table extends Migration {

    public $table = "user_tat";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->integer(),
            'stages' => $this->integer(),
            'start_date' => $this->dateTime(),
            'end_date' => $this->dateTime(),
            'meta_data' => $this->json(),
            'action_types' => $this->integer(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("$this->table-user_id", $this->table, 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
