<?php

use common\ebl\migration\Migration;

/**
 * Class m200504_131535_alter_nas_table
 */
class m200504_131535_alter_nas_table extends Migration {

    public $table = 'nas';

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumnIfNotExists($this->table, 'username', $this->string()->notNull());
        $this->addColumnIfNotExists($this->table, 'password', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m200504_131535_alter_nas_table cannot be reverted.\n";

        return TRUE;
    }

}
