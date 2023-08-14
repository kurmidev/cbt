<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer}}`.
 */
class m200909_083205_create_customer_table extends Migration {

    public $table = "customer";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey(),
            'cid' => $this->string()->unique(),
            'name' => $this->string()->notNull(),
            'mobile_no' => $this->string(),
            'phone_no' => $this->string(),
            'email' => $this->string(),
            'gender' => $this->string(),
            'dob' => $this->date(),
            'connection_type' => $this->integer()->notNull(),
            'operator_id' => $this->integer()->notNull(),
            'road_id' => $this->integer(),
            'building_id' => $this->string(),
            'address' => $this->string(),
            'billing_address' => $this->string(),
            'gst_no' => $this->string(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("IX-{$this->table}-mobile_no", $this->table, 'mobile_no');
        $this->addForeignKey("IX-{$this->table}-operator_id", $this->table, 'operator_id','operator','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
