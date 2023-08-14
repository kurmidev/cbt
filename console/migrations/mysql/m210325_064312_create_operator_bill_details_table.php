<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operator_bill_details}}`.
 */
class m210325_064312_create_operator_bill_details_table extends Migration {

    public $table = "operator_bill_details";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey(),
            "bill_id" => $this->bigInteger()->notNull(),
            "operator_id" => $this->integer()->notNull(),
            "distributor_id" => $this->integer()->notNull(),
            "bill_no" => $this->string()->notNull(),
            "bill_month" => $this->date()->notNull(),
            "bill_start_date" => $this->date()->notNull(),
            "bill_end_date" => $this->date()->notNull(),
            "trans_type" => $this->integer()->notNull(),
            "trans_type_name" => $this->string(),
            "product_id" => $this->integer(),
            "product_name" => $this->string(),
            "per_day_rate" => $this->money(),
            "counts" => $this->integer()->notNull(),
            "amount" => $this->money(),
            "tax" => $this->money(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey("FK-{$this->table}-bill_id", $this->table, "bill_id", "operator_bill", "id");
        $this->createIndex("IX-{$this->table}-bill_month", $this->table, 'bill_month');
        $this->createIndex("IX-{$this->table}-operator_id", $this->table, 'operator_id');
        $this->createIndex("IX-{$this->table}-bill_no", $this->table, 'bill_no');
        $this->createIndex("IX-{$this->table}-distributor_id", $this->table, 'distributor_id');
        $this->createIndex("IX-{$this->table}-trans_type", $this->table, 'trans_type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
