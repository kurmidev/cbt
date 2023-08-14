<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wallet}}`.
 */
class m190820_152043_create_wallet_table extends common\ebl\migration\Migration {

    public $tableName = "operator_wallet";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'cr_operator_id' => $this->integer()->null(),
            'dr_operator_id' => $this->integer()->null(),
            'operator_id' => $this->integer()->null(),
            'amount' => $this->money()->defaultValue(0),
            'tax' => $this->money()->defaultValue(0),
            'transaction_id' => $this->integer()->null(),
            'trans_type' => $this->integer()->notNull(),
            'receipt_no' => $this->string()->unique(),
            'balance' => $this->money()->notNull()->defaultValue(0),
            'remark' => $this->string()->null(),
            'meta_data' => $this->json()->null(),
            'cancel_id' => $this->integer(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey("FK-$this->tableName-operator_id", $this->tableName, 'operator_id', 'operator', 'id');
        $this->createIndex("IN-$this->tableName-cr_operator_id", $this->tableName, 'cr_operator_id');
        $this->createIndex("IN-$this->tableName-dr_operator_id", $this->tableName, 'dr_operator_id');
        $this->createIndex("IN-$this->tableName-operator_id", $this->tableName, 'operator_id');
        $this->createIndex("IN-$this->tableName-receipt_no", $this->tableName, 'receipt_no');
        $this->createIndex("IN-$this->tableName-added_on", $this->tableName, 'added_on');
        $this->createIndex("IN-$this->tableName-trans_type", $this->tableName, 'trans_type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {

        $this->dropIndexIfExist("IN-$this->tableName-cr_operator_id", $this->tableName);
        $this->dropIndexIfExist("IN-$this->tableName-dr_operator_id", $this->tableName);
        $this->dropIndexIfExist("IN-$this->tableName-operator_id", $this->tableName);
        $this->dropIndexIfExist("IN-$this->tableName-added_on", $this->tableName);
        $this->dropIndexIfExist("IN-$this->tableName-type", $this->tableName);
        $this->dropIndexIfExist("IN-$this->tableName-receipt_no", $this->tableName);
        $this->dropTable($this->tableName);
    }

}
