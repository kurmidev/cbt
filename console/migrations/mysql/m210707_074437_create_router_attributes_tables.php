<?php

use yii\db\Migration;

/**
 * Class m210707_074437_create_router_attributes_tables
 */
class m210707_074437_create_router_attributes_tables extends Migration {

    public $table = "router_attributes";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'router_id' => $this->integer(),
            "name" => $this->string(),
            "op" => $this->string(),
            "group" => $this->string(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
        $this->createIndex("ui-{$this->table}-router_id-name-group", $this->table, ['router_id', 'name', 'group'], 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m210707_074437_create_router_attributes_tables cannot be reverted.\n";
        $this->dropTable($this->table);
        return true;
    }
}
