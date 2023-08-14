<?php

use common\ebl\migration\Migration;

/**
 * Handles the creation of table `{{%opt_payment_reconsile}}`.
 */
class m200311_133001_create_opt_payment_reconsile_table extends Migration {

    public $tableName = "opt_payment_reconsile";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'inst_no' => $this->string(),
            'inst_date' => $this->date(),
            'bank' => $this->string(),
            'receipt_no' => $this->string(),
            'wallet_id' => $this->integer(),
            'amount' => $this->money(),
            'tax' => $this->money(),
            'status' => $this->integer(),
            'deposited_bank' => $this->string(),
            'deposited_by' => $this->integer(),
            'desposited_on' => $this->date(),
            'realized_on' => $this->date(),
            'realised_by' => $this->integer(),
            'remark' => $this->string(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex("UIX-$this->tableName-inst_no-receipt_no", $this->tableName, ['inst_no', 'receipt_no', 'wallet_id'], TRUE);
        $this->addForeignKey("FK-$this->tableName-wallet_id", $this->tableName, 'wallet_id', 'operator_wallet', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropAllForeignKeyIfExist($this->tableName);
        $this->dropTable($this->tableName);
    }

}
