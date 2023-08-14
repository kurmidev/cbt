<?php

use yii\db\Migration;

/**
 * Class m211027_061032_voucher_master
 */
class m211027_061032_voucher_master extends Migration {

    public $table = "voucher_master";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            "id" => $this->primaryKey(),
            "coupon" => $this->string()->unique(),
            "operator_id" => $this->integer(),
            "account_id" => $this->bigInteger(),
            "username" => $this->string(),
            "expiry_date" => $this->date(),
            "opt_wallet_id" => $this->integer(),
            "cus_wallet_id" => $this->integer(),
            "status" => $this->integer(),
            "is_locked" => $this->integer(),
            "opt_amount" => $this->money(),
            "cust_amount" => $this->money(),
            "plan_id" => $this->integer(),
            "remark" => $this->string(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey("fk-{$this->table}-operator_id", $this->table, 'operator_id', 'operator', 'id');
        $this->addForeignKey("fk-{$this->table}-account_id", $this->table, 'account_id', 'customer_account', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m211027_061032_voucher_master cannot be reverted.\n";
        $this->dropTable($this->table);
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m211027_061032_voucher_master cannot be reverted.\n";

      return false;
      }
     */
}
