<?php

/**
 * Handles the creation of table `{{%location}}`.
 */
class m190716_151851_create_location_table extends common\ebl\migration\Migration {

    public $tableName = "location";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {

        $this->dropTableIfExists($this->tableName);

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->unique()->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'email' => $this->string(),
            'mobile_no' => $this->string(),
            'state_id' => $this->integer()->notNull()->defaultValue(0),
            'city_id' => $this->integer()->notNull()->defaultValue(0),
            'area_id' => $this->integer()->notNull()->defaultValue(0),
            'road_id' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(\common\ebl\Constants::STATUS_ACTIVE),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex(
                'idx-' . $this->tableName . '-status', $this->tableName, ['status']
        );
        $this->createIndex(
                'idx-' . $this->tableName . '-state_id', $this->tableName, ['state_id']
        );
        $this->createIndex(
                'idx-' . $this->tableName . '-city_id', $this->tableName, ['city_id']
        );
        $this->createIndex(
                'idx-' . $this->tableName . '-area_id', $this->tableName, ['area_id']
        );
        $this->createIndex(
                'idx-' . $this->tableName . '-road_id', $this->tableName, ['road_id']
        );
        $this->createIndex(
                'iux-' . $this->tableName . '-name', $this->tableName, ['name'],1
        );
         $this->createIndex(
                'iux-' . $this->tableName . '-code', $this->tableName, ['code'],1
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropIndex('idx-' . $this->tableName . '-status', $this->tableName);
        $this->dropIndex('idx-' . $this->tableName . '-state_id', $this->tableName);
        $this->dropIndex('idx-' . $this->tableName . '-city_id', $this->tableName);
        $this->dropIndex('idx-' . $this->tableName . '-area_id', $this->tableName);
        $this->dropIndex('idx-' . $this->tableName . '-road_id', $this->tableName);
        $this->dropIndex('iux-' . $this->tableName . '-name', $this->tableName);
        $this->dropIndex('iux-' . $this->tableName . '-code', $this->tableName);
        $this->dropTable('location');
    }

}
