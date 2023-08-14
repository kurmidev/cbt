<?php

use yii\db\Migration;

class m210511_095851_create_complaint_table extends Migration {

    public $table = "complaint";

    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "ticketno" => $this->string()->notNull(),
            "username" => $this->string()->notNull(),
            "operator_id" => $this->integer()->notNull(),
            "account_id" => $this->bigInteger()->notNull(),
            "customer_id" => $this->bigInteger()->notNull(),
            "category_id" => $this->integer()->notNull(),
            "status" => $this->integer()->notNull(),
            "opening" => $this->string()->notNull(),
            "closing" => $this->string(),
            "stages" => $this->integer()->notNull(),
            "status" => $this->integer(),
            "assigned_to" => $this->json(),
            "extra_details" => $this->json(),
            "current_assigned" => $this->integer(),
            "opening_date" => $this->dateTime(),
            "closing_date" => $this->dateTime(),
            "nextfollowup"=> $this->dateTime(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
        
        $this->addForeignKey("fk-{$this->table}-account_id", $this->table,"account_id" , "customer_account", "id");
        $this->addForeignKey("fk-{$this->table}-customer_id", $this->table,"customer_id" , "customer", "id");
        $this->addForeignKey("fk-{$this->table}-operator_id", $this->table,"operator_id" , "operator", "id");
        $this->addForeignKey("fk-{$this->table}-category_id", $this->table,"category_id" , "comp_cat", "id");
        $this->createIndex("ux-{$this->table}-ticketno", $this->table, 'ticketno',1);
        $this->createIndex("ix-{$this->table}-stages", $this->table, 'stages');
        $this->createIndex("ix-{$this->table}-current_assigned", $this->table, 'current_assigned');
                
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
