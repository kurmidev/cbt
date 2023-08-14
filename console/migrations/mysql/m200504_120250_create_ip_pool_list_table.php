<?php

use common\ebl\migration\Migration;

/**
 * Handles the creation of table `{{%ip_pool_list}}`.
 */
class m200504_120250_create_ip_pool_list_table extends Migration {

    public $table = "ip_pool_list";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'pool_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'ipaddress' => $this->string()->notNull(),
            'plugin_id' => $this->integer()->notNull(),
            'operator_id' => $this->integer()->null(),
            "account_id" => $this->integer()->null(),
            "start_date" => $this->date()->null(),
            "end_date" => $this->date()->null(),
            "per_day_amount" => $this->money(),
            "amount" => $this->money(),
            "tax" => $this->money(),
            "per_day_mrp" => $this->money(),
            "mrp" => $this->money(),
            "mrp_tax" => $this->money(),
            "assigned_on" => $this->date(),
            "assigned_by" => $this->integer(),
            'status' => $this->tinyInteger()->notNull(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey("fk-$this->table-pool_id", $this->table, 'pool_id', 'ip_pool_master', 'id');
        $this->createIndexIfNotExist("uix-$this->table-ipaddress", $this->table, 'ip_address', 1);
        $this->createIndexIfNotExist("uix-$this->table-status", $this->table, 'status');
        $this->createIndexIfNotExist("uix-$this->table-assigned_id", $this->table, 'assigned_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropAllForeignKeyIfExist($this->table);
        $this->dropTable($this->table);
    }

}
