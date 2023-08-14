<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%complaint_details}}`.
 */
class m210511_101718_create_complaint_details_table extends Migration {

    public $table = "complaint_details";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "account_id" => $this->bigInteger()->notNull(),
            "complaint_id" => $this->integer()->notNull(),
            "comments" => $this->string()->notNull(),
            "nextfollowup" => $this->dateTime(),
            "stage" => $this->integer(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
        $this->addForeignKey("fk-{$this->table}-complaint_id", $this->table, "complaint_id", "complaint", "id");
        $this->addForeignKey("fk-{$this->table}-account_id", $this->table, "account_id", "customer_account", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
