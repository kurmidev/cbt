<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_account_plan}}`.
 */
class m200909_085126_create_customer_account_plan_table extends Migration {

    public $table = "customer_account_bouquet";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey(),
            'account_id' => $this->bigInteger(),
            'customer_id' => $this->bigInteger(),
            'operator_id' => $this->integer()->notNull(),
            'road_id' => $this->integer(),
            'building_id' => $this->string(),
            'router_type' => $this->integer(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
            'cal_end_date' => $this->date(),
            'status' => $this->integer(),
            'bouquet_name' => $this->string(),
            'bouquet_id' => $this->integer()->notNull(),
            "bouquet_type" => $this->integer()->notNull(),
            'is_refundable' => $this->integer(),
            'meta_data' => $this->json(),
            'rate_id' => $this->integer(),
            'per_day_amount' => $this->money(),
            'per_day_mrp' => $this->money(),
            'amount' => $this->money(),
            'tax' => $this->money(),
            'mrp' => $this->money(),
            'mrp_tax' => $this->money(),
            'refund_amount' => $this->money(),
            'refund_tax' => $this->money(),
            'refund_mrp' => $this->money(),
            'refund_mrp_tax' => $this->money(),
            'upload' => $this->string(),
            'download' => $this->string(),
            'remark' => $this->string(),
            'renewal_type' => $this->integer(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey("IX-{$this->table}-operator_id", $this->table, 'operator_id', 'operator', 'id');
        $this->addForeignKey("IX-{$this->table}-customer_id", $this->table, 'customer_id', 'customer', 'id');
        $this->addForeignKey("IX-{$this->table}-account_id", $this->table, 'account_id', 'customer_account', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
