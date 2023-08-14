<?php

use common\ebl\migration\Migration;
use common\ebl\Constants as C;
use common\models\TaxMaster;

/**
 * Handles the creation of table `{{%tax}}`.
 */
class m190718_070524_create_tax_table extends Migration {

    public $tableName = "tax";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'code' => $this->string()->notNull()->unique(),
            'type' => $this->smallInteger()->defaultValue(common\ebl\Constants::TAX_PERCENTAGE),
            'value' => $this->money()->notNull(),
            'applicable_on' => $this->json()->notNull(),
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
                'idx-' . $this->tableName . '-name', $this->tableName, ['name']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropIndex('idx-' . $this->tableName . '-status', $this->tableName);
        $this->dropIndex('idx-' . $this->tableName . '-name', $this->tableName);
        $this->dropTable($this->tableName);
    }

}
