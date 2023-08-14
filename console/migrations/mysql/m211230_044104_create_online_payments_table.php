<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%online_payments}}`.
 */
class m211230_044104_create_online_payments_table extends Migration {

    public $table = "online_payments";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "payment_for" => $this->integer()->notNull(),
            "gateway_type"=> $this->string()->notNull(),
            "request_data" => $this->json()->notNull(),
            "response_data" => $this->json(),
            "order_id" => $this->string()->unique()->notNull(),
            "amount" => $this->money()->notNull(),
            "account_id" => $this->bigInteger(),
            "operator_id" => $this->integer()->notNull(),
            "status" => $this->integer()->notNull()->defaultValue(common\ebl\Constants::PAYMENT_PENDING),
            "meta_data" => $this->json(),
            "retry_attempts" => $this->integer(),
            "opt_wallet_id" => $this->integer(),
            "opt_receipt_no" => $this->string(),
            "sub_wallet_id" => $this->integer(),
            "sub_receipt_no" => $this->string(),
            "added_on" => $this->dateTime(),
            "added_by" => $this->integer(),
            "updated_on" => $this->dateTime(),
            "updated_by" => $this->integer()
        ]);
        
        $this->createIndex("ix-{$this->table}-order_id", $this->table, 'order_id');
        $this->createIndex("ix-{$this->table}-payment_for", $this->table, 'payment_for');
        $this->createIndex("ix-{$this->table}-status", $this->table, 'status');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
