<?php

use common\ebl\migration\Migration;

/**
 * Class m210326_100437_alter_subscriber_wallet_table
 */
class m210326_100437_alter_subscriber_wallet_table extends Migration {

    public $table = "customer_wallet";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumnIfNotExists($this->table, "bouquet_id", $this->integer());
        $this->addColumnIfNotExists($this->table, "start_date", $this->date());
        $this->addColumnIfNotExists($this->table, "end_date", $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m210326_100437_alter_subscriber_wallet_table cannot be reverted.\n";
        $this->dropColumnIfExist($this->table, "bouquet_id");
        $this->dropColumnIfExist($this->table, "start_date");
        $this->dropColumnIfExist($this->table, "end_date");
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m210326_100437_alter_subscriber_wallet_table cannot be reverted.\n";

      return false;
      }
     */
}
