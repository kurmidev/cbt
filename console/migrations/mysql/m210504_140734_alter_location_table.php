<?php

use yii\db\Migration;

/**
 * Class m210504_140734_alter_location_table
 */
class m210504_140734_alter_location_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->dropIndex("iux-location-name", "location");
        $this->createIndex("iux-location-name-type", "location", ['name', 'type']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m210504_140734_alter_location_table cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m210504_140734_alter_location_table cannot be reverted.\n";

      return false;
      }
     */
}
