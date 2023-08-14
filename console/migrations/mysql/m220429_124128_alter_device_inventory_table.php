<?php

use yii\db\Migration;

/**
 * Class m220429_124128_alter_device_inventory_table
 */
class m220429_124128_alter_device_inventory_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn(\common\models\DeviceInventory::tableName(), "upload_id", $this->integer());
        $this->addColumn(\common\models\PurchaseOrder::tableName(), "upload_id", $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m220429_124128_alter_device_inventory_table cannot be reverted.\n";

        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m220429_124128_alter_device_inventory_table cannot be reverted.\n";

      return false;
      }
     */
}
