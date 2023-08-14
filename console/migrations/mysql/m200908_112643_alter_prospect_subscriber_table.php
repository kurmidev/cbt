<?php

use common\ebl\migration\Migration;

/**
 * Class m200908_112643_alter_prospect_subscriber_table
 */
class m200908_112643_alter_prospect_subscriber_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumnIfNotExists('prospect_subscriber', 'dob', $this->date());
        $this->addColumnIfNotExists('prospect_reply', 'meta_data', $this->json());
        $this->addColumnIfNotExists('prospect_reply', 'ticketno', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m200908_112643_alter_prospect_subscriber_table cannot be reverted.\n";

        return TRUE;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m200908_112643_alter_prospect_subscriber_table cannot be reverted.\n";

      return false;
      }
     */
}
