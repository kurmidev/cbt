<?php

use yii\db\Migration;

/**
 * Class m211101_063625_alter_customer_account_plan_table
 */
class m211101_063625_alter_customer_account_plan_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn(common\models\CustomerAccountBouquet::tableName(), 'voucher_amount', $this->money()->defaultValue("0"));
        $this->addColumn(common\models\CustomerAccountBouquet::tableName(), 'voucher_tax', $this->money()->defaultValue(0));
        $this->addColumn(common\models\CustomerAccountBouquet::tableName(), 'voucher_id', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m211101_063625_alter_customer_account_plan_table cannot be reverted.\n";
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m211101_063625_alter_customer_account_plan_table cannot be reverted.\n";

      return false;
      }
     */
}
