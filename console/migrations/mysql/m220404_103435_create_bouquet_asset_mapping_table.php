<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bouquet_asset_mapping}}`.
 */
class m220404_103435_create_bouquet_asset_mapping_table extends Migration {

    public $table = "bouquet_asset_mapping";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        try {
            $this->createTable($this->table, [
                'id' => $this->primaryKey(),
                "bouquet_id" => $this->integer()->notNull(),
                "asset_id" => $this->integer()->notNull(),
                'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
                'updated_on' => $this->dateTime()->null(),
                'added_by' => $this->integer(),
                'updated_by' => $this->integer()
            ]);

            $this->addForeignKey("IX-{$this->table}-bouquet_id", $this->table, "bouquet_id", \common\models\Bouquet::tableName(), 'id');
            $this->addForeignKey("IX-{$this->table}-asset_id", $this->table, "asset_id", \common\models\BouquetAssets::tableName(), 'id');
        } catch (Exception $ex) {
            
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->$table);
        return true;
    }

}
