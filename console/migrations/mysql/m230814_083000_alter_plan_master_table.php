<?php

use common\models\PlanMaster;
use yii\db\Migration;

/**
 * Class m230814_083000_alter_plan_master_table
 */
class m230814_083000_alter_plan_master_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        try{
            $this->dropColumn(PlanMaster::tableName(),'is_exclusive');
        }catch(Exception $ex){

        }
        try{
            $this->dropColumn(PlanMaster::tableName(),'is_promotional');
        }catch(Exception $ex){

        }
        try{
            $this->dropColumn(PlanMaster::tableName(),'billing_type');
        }catch(Exception $ex){

        }
        try{
            $this->dropColumn(PlanMaster::tableName(),'days');
        }catch(Exception $ex){

        }
        try{
            $this->dropColumn(PlanMaster::tableName(),'free_days');
        }catch(Exception $ex){

        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230814_083000_alter_plan_master_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230814_083000_alter_plan_master_table cannot be reverted.\n";

        return false;
    }
    */
}
