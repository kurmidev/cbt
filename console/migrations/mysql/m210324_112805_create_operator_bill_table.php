<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operator_bill}}`.
 */
class m210324_112805_create_operator_bill_table extends Migration {

    public $table = "operator_bill";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey(),
            "operator_id" => $this->integer(),
            "distributor_id" => $this->integer(),
            "bill_no" => $this->string(),
            "bill_month" => $this->date(),
            "start_date" => $this->date(),
            "end_date" => $this->date(),
            "opening_amount" => $this->money(),
            "payment" => $this->money(),
            "plan_charges" => $this->json(),
            "debit_charges" => $this->json(),
            "debit_charges_nt" => $this->money(),
            "credit_charges" => $this->json(),
            "credit_charges_nt" => $this->money(),
            "hardware_charges" => $this->json(),
            "discount" => $this->json(),
            "sub_amount" => $this->money(),
            "sub_amount_tax" => $this->money(),
            "total_amount" => $this->money(),
            "total_tax" => $this->money(),
            "total" => $this->money(),
            "closing_amount" => $this->money(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("IX-{$this->table}-bill_month", $this->table, 'bill_month');
        $this->createIndex("IX-{$this->table}-operator_id", $this->table, 'operator_id');
        $this->createIndex("IX-{$this->table}-bill_no", $this->table, 'bill_no');
        $this->createIndex("IX-{$this->table}-distributor_id", $this->table, 'distributor_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
