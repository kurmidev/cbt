<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operator}}`.
 */
class m190814_165937_create_operator_table extends common\ebl\migration\Migration {

    public $tableName = "operator";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->notNull()->unique(),
            'contact_person' => $this->string()->notNull(),
            'mobile_no' => $this->string()->notNull(),
            'telephone_no' => $this->string()->null(),
            'email' => $this->string()->null(),
            'address' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
            'mso_id' => $this->integer()->notNull()->defaultValue(0),
            'distributor_id' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->integer()->notNull()->defaultValue(common\ebl\Constants::STATUS_ACTIVE),
            'state_id' => $this->integer()->notNull()->defaultValue(0),
            'city_id' => $this->integer()->notNull()->defaultValue(0),
            'gst_no' => $this->string()->null(),
            'pan_no' => $this->string()->null(),
            'tan_no' => $this->string()->null(),
            'billing_by' => $this->integer()->notNull(),
            'username' => $this->string()->notNull()->unique(),
            'meta_data' => $this->json(),
            'is_verified' => $this->integer(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey("fp-$this->tableName-state_id", $this->tableName, 'state_id', 'location', 'id');
        $this->addForeignKey("fp-$this->tableName-city_id", $this->tableName, 'city_id', 'location', 'id');
        $this->createIndex("IX-$this->tableName-code", $this->tableName, ['code'], 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropForeignKeyIfExist("fp-$this->tableName-state_id", $this->tableName);
        $this->dropForeignKeyIfExist("fp-$this->tableName-city_id", $this->tableName);
        $this->dropTable($this->tableName);
    }

}
