<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prospect_reply}}`.
 */
class m200907_103300_create_prospect_reply_table extends Migration {

    public $table = "prospect_reply";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey(),
            'prospect_id' => $this->bigInteger(),
            'remark' => $this->string()->notNull(),
            'stages' => $this->integer()->notNull(),
            'status'=> $this->integer()->notNull(),
            'action_assigned' => $this->integer()->notNull(),
            'action_taken' => $this->string(),
            'start_on' => $this->dateTime(),
            'done_on' => $this->dateTime(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("$this->table-stages", $this->table, 'stages');
        $this->createIndex("$this->table-status", $this->table, 'status');
        $this->addForeignKey("FK-$this->table-prospect_id", $this->table, 'prospect_id', 'prospect_subscriber', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }
    

}
