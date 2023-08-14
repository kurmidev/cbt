<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prospect_subscriber}}`.
 */
class m200907_073753_create_prospect_subscriber_table extends Migration {

    public $table = "prospect_subscriber";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey(),
            'ticket_no' => $this->string()->unique()->notNull(),
            'name' => $this->string()->notNull(),
            'mobile_no' => $this->string()->notNull(),
            'email' => $this->string(),
            'phone_no' => $this->string(),
            'gender' => $this->integer(),
            'connection_type' => $this->integer(),
            'address' => $this->string(),
            'area_name' => $this->string(),
            'description' => $this->string(),
            'stages' => $this->integer()->notNull(),
            'operator_id' => $this->integer(),
            'subscriber_id' => $this->integer(),
            'account_id' => $this->integer(),
            'assigned_engg' => $this->integer(),
            'is_verified' => $this->integer(),
            'is_verified_on' => $this->date(),
            'is_verified_by' => $this->integer(),
            'status' => $this->integer(),
            'meta_data' => $this->json(),
            'next_follow' => $this->date(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("$this->table-stages", $this->table, 'stages');
        $this->createIndex("$this->table-status", $this->table, 'status');
        $this->createIndex("$this->table-is_verified", $this->table, 'is_verified');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
