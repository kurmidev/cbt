<?php

namespace common\ebl\migration;

class Migration extends \yii\db\Migration {

    public $tableName;
    public $modelName;

    public function __construct($config = array()) {
        parent::__construct($config);
//        $this->safeDown();
    }

    public function money($precision = 19, $scale = 2) {
        return parent::money($precision, $scale);
    }

    public function __destruct() {
        echo "\t>>>>Clear Cache..\n";
        \Yii::$app->cache->flush();
    }

    function dropTable($table) {
        try {
            parent::dropTable($table);
        } catch (\Exception $e) {
            print_R($e);
//            $sql = "Drop view $table";
//            $this->execute($sql);
        }
    }

    function createTable($table, $columns, $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB') {
        if ($this->getSchema($table)) {
            $this->dropTable($table);
        }
        parent::createTable($table, $columns, $options);
    }

    function getSchema($table) {
        if ($schema = \Yii::$app->db->schema->getTableSchema($table, true)) {
            return $schema;
        }
        return false;
    }

    function dropTableForcefully() {
        if ($schema = \Yii::$app->db->schema->getTableSchema($this->tableName, true)) {
            if (isset($schema->foreignKeys)) {
                foreach ($schema->foreignKeys as $fk => $k) {
                    $this->dropForeignKey($fk, $this->tableName);
                }
            }
            $this->dropTable($this->tableName);
        }
    }

    function dropTableIfExists($table) {
        if ($schema = $this->getSchema($table)) {
            parent::dropTable($table);
        }
    }

    function tableExists($table) {
        return $this->getSchema($table);
    }

    function foreignKeyExists($name, $table) {
        if ($schema = $this->getSchema($table)) {
            return isset($schema->foreignKeys[$name]);
        }
        return false;
    }

    function columnExists($table, $column) {
        if ($schema = $this->getSchema($table)) {
            return isset($schema->columns[$column]);
        }
        return false;
    }

    function addColumnIfNotExists($table, $column, $type) {
        if (!$this->columnExists($table, $column)) {
            parent::addColumn($table, $column, $type);
        }
    }

    function indexExists($indexName, $table) {
        if ($schema = $this->getSchema($table)) {
//            \components\helper\Utils::l($schema);
            return isset($schema->columns[$indexName]);
        }
        return false;
    }

    function dropColumnIfExist($table, $column) {
        if ($this->columnExists($table, $column)) {
            $this->dropColumn($table, $column);
        }
    }

    function dropIndexIfExist($name, $table) {
        try {
            if ($this->isPgsql()) {
                $time = $this->beginCommand("drop index IF EXISTS $name on $table");
                $this->db->createCommand('drop index IF EXISTS "' . $name . '"')->execute();
                $this->endCommand($time);
            } else {
                $this->dropIndex($name, $table);
                return true;
            }
        } catch (\Throwable $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    function createIndexIfNotExist($name, $table, $columns, $unique = false) {
        try {
            $this->createIndex($name, $table, $columns, $unique);
        } catch (\Throwable $ex) {
//            echo $ex->getCode();
//            exit;
            if (!in_array($ex->getCode(), [42, 42000])) {
                Throw $ex;
            }
        }
    }

    function dropForeignKeyIfExist($name, $table) {
        if ($schema = $this->getSchema($table)) {
            if (isset($schema->foreignKeys[$name])) {
                $this->dropForeignKey($name, $table);
            }
        }
    }

    function foreignKeyExist($name, $table) {
        if ($schema = $this->getSchema($table)) {
            if (isset($schema->foreignKeys[$name])) {
                return true;
            }
        }
        return false;
    }

    function dropAllForeignKeyIfExist($table) {
        if ($schema = $this->getSchema($table)) {
            if (isset($schema->foreignKeys)) {
                foreach ($schema->foreignKeys as $fk => $k) {
                    $this->dropForeignKey($fk, $table);
                }
            }
        }
    }

    public function jsonDataType() {
        return JSON_NOT_SUPPORTED ? $this->text() : $this->json();
    }

    public function isPgsql() {
        return $this->db->driverName === 'pgsql';
    }

}
