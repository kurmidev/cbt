<?php

use common\ebl\migration\Migration;

/**
 * Class m210924_062321_alter_reconsile_table
 */
class m210924_062321_alter_reconsile_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumnIfNotExists(common\models\OptPaymentReconsile::tableName(), "bounce_id", $this->integer());
        $this->addColumnIfNotExists(common\models\OptPaymentReconsile::tableName(), "cancel_id", $this->integer());
        $this->addColumnIfNotExists(common\models\OperatorWallet::tableName(), "bounce_id", $this->integer());

        $this->createIndex(common\models\OptPaymentReconsile::tableName() . "-uix-bounce_id", common\models\OptPaymentReconsile::tableName(), 'bounce_id', 1);
        $this->createIndex(common\models\OptPaymentReconsile::tableName() . "-uix-credit_id", common\models\OptPaymentReconsile::tableName(), 'cancel_id', 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m210924_062321_alter_reconsile_table cannot be reverted.\n";

        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m210924_062321_alter_reconsile_table cannot be reverted.\n";

      return false;
      }
     */
}
