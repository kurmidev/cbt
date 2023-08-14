<?php

use yii\db\Migration;

/**
 * Class m220730_101956_alter_subscriber_transaction_table
 */
class m220730_101956_alter_subscriber_transaction_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        try {
            $this->addColumn(\common\models\CustomerWallet::tableName(), "trans_grp", $this->string());
        } catch (Exception $ex) {
        }
        try {
            $this->addColumn(\common\models\OperatorWallet::tableName(), "trans_grp", $this->string());
        } catch (Exception $ex) {
        }
        try {
            $this->addColumn(\common\models\CustomerWallet::tableName(), 'trans_id', $this->integer());
        } catch (Exception $ex) {
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220730_101956_alter_subscriber_transaction_table cannot be reverted.\n";

        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m220730_101956_alter_subscriber_transaction_table cannot be reverted.\n";

      return false;
      }
     */
}
