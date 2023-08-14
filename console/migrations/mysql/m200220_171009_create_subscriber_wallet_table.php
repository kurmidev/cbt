<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriber_wllet}}`.
 */
class m200220_171009_create_subscriber_wallet_table extends Migration {

    public $tableName = "customer_wallet";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'subscriber_id' => $this->integer()->notNull(),
            'account_id' => $this->integer()->notNull(),
            'operator_id' => $this->integer()->null(),
            'trans_id' => $this->integer()->notNull(),
            'trans_type' => $this->integer()->notNull(),
            'amount' => $this->money()->defaultValue(0),
            'tax' => $this->money()->defaultValue(0),
            'receipt_no' => $this->string()->unique(),
            'balance' => $this->money()->notNull()->defaultValue(0),
            'remark' => $this->string()->null(),
            'meta_data' => $this->json()->null(),
            'cancel_id' => $this->integer()->null(),
            "trans_grp" => $this->string(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey("FK-$this->tableName-operator_id", $this->tableName, 'operator_id', 'operator', 'id');
        $this->createIndex("IN-$this->tableName-operator_id", $this->tableName, 'operator_id');
        $this->createIndex("IN-$this->tableName-receipt_no", $this->tableName, 'receipt_no');
        $this->createIndex("IN-$this->tableName-added_on", $this->tableName, 'added_on');
        $this->createIndex("IN-$this->tableName-trans_type", $this->tableName, 'trans_type');
        $this->createIndex("IN-$this->tableName-trans_grp", $this->tableName, 'trans_grp');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropAllForeignKeyIfExist($this->tableName);
        $this->dropTable($this->tableName);
    }

}
