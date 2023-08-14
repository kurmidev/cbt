<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_bill}}`.
 */
class m210416_083732_create_customer_bill_table extends Migration {

    public $table = "customer_bill";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey(),
            "customer_id" => $this->bigInteger(),
            "account_id" => $this->bigInteger(),
            "operator_id" => $this->integer(),
            "bill_month" => $this->date(),
            "bill_start_date" => $this->date(),
            "bill_end_date" => $this->date(),
            "bill_no" => $this->string(),
            "opening" => $this->money(),
            "payment" => $this->money(),
            "subscription_charges" => $this->json(),
            "debit_charges" => $this->json(),
            "debit_charges_nt" => $this->money(),
            "credit_charges" => $this->json(),
            "credit_charges_nt" => $this->money(),
            "hardware_charges" => $this->json(),
            "discount" => $this->json(),
            "discount_nt" => $this->money(),
            "sub_amount" => $this->money(),
            "sub_tax" => $this->money(),
            "total" => $this->money(),
            "closing" => $this->money(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey("fk-{$this->table}-account_id", $this->table, 'account_id', 'customer_account', 'id');
        $this->addForeignKey("fk-{$this->table}-operator_id", $this->table, 'operator_id', 'operator', 'id');
        $this->createIndex("ix-{$this->table}-bill_no", $this->table, "bill_no", 1);
        $this->createIndex("ix-{$this->table}-account_id", $this->table, "operator_id");
        $this->createIndex("ix-{$this->table}-customer_id", $this->table, "customer_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
