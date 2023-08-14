<?php



class m210527_095331_alter_operator_table extends common\ebl\migration\Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumnIfNotExists("operator", "ro_id", $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m210527_095331_alter_operator_table cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m210527_095331_alter_operator_table cannot be reverted.\n";

      return false;
      }
     */
}
