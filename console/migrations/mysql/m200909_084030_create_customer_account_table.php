<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_account}}`.
 */
class m200909_084030_create_customer_account_table extends Migration {

    public $table = "customer_account";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey(),
            'cid' => $this->string(),
            'customer_id' => $this->bigInteger(),
            'username' => $this->string()->unique(),
            'password' => $this->string(),
            'operator_id' => $this->integer()->notNull(),
            'road_id' => $this->integer(),
            'building_id' => $this->string(),
            'router_type' => $this->integer(),
            'mac_address' => $this->json(),
            'static_ip' => $this->string(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
            'status' => $this->integer(),
            'account_types' => $this->integer(),
            'is_auto_renew' => $this->integer()->defaultValue('0'),
            'meta_data' => $this->json(),
            'current_plan' => $this->json(),
            'prospect_id'=> $this->integer(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
        $this->addForeignKey("IX-{$this->table}-operator_id", $this->table, 'operator_id', 'operator', 'id');
        $this->addForeignKey("IX-{$this->table}-customer_id", $this->table, 'customer_id', 'customer', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
