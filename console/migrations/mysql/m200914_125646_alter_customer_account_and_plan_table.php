<?php

use common\ebl\migration\Migration;

/**
 * Class m200914_125646_alter_customer_account_and_plan_table
 */
class m200914_125646_alter_customer_account_and_plan_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumnIfNotExists('customer_account', "remark", $this->json());
        $this->addColumnIfNotExists('customer_account_bouquet', "remark", $this->json());

        $this->addColumnIfNotExists('customer_account', "history", $this->json());
        $this->addColumnIfNotExists('customer_account_bouquet', "history", $this->json());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m200914_125646_alter_customer_account_and_plan_table cannot be reverted.\n";

        return TRUE;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m200914_125646_alter_customer_account_and_plan_table cannot be reverted.\n";

      return false;
      }
     */
}
