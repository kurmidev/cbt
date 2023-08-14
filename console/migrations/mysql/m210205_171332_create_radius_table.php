<?php

use common\ebl\migration\Migration;

/**
 * Handles the creation of table `{{%radacct}}`.
 */
class m210205_171332_create_radius_table extends Migration {

    public $table = "radius_accounting";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey(),
            "acctsessionid" => $this->string()->notNull()->defaultValue(''),
            "acctuniqueid" => $this->string()->notNull()->defaultValue(''),
            "username" => $this->string()->notNull(),
            "realm" => $this->string(),
            "nasipaddress" => $this->string()->notNull(),
            "nasportid" => $this->string(),
            "nasporttype" => $this->string(),
            "acctstarttime" => $this->dateTime()->notNull(),
            "acctupdatetime" => $this->dateTime(),
            "acctstoptime" => $this->dateTime(),
            "acctinterval" => $this->bigInteger(),
            "acctsessiontime" => $this->bigInteger()->unsigned(),
            "acctauthentic" => $this->string(),
            "connectinfo_start" => $this->string(),
            "connectinfo_stop" => $this->string(),
            "acctinputoctets" => $this->bigInteger(),
            "acctoutputoctets" => $this->bigInteger(),
            "calledstationid" => $this->string()->notNull(),
            "callingstationid" => $this->string()->notNull(),
            "acctterminatecause" => $this->string(),
            "servicetype" => $this->string(),
            "framedprotocol" => $this->string(),
            "framedipaddress" => $this->string()->notNull(),
            "framedipv6address" => $this->string(),
            "framedipv6prefix" => $this->string(),
            "framedinterfaceid" => $this->string(),
            "delegatedipv6prefix" => $this->string(),
        ]);

        $this->createIndex("uq-acctuniqueid", $this->table, ['acctuniqueid'], 1);
        $this->createIndex('ix-username', $this->table, ["username"]);
        $this->createIndex('ix-framedipaddress', $this->table, ["framedipaddress"]);
        $this->createIndex('ix-acctsessionid', $this->table, ["acctsessionid"]);
        $this->createIndex('ix-acctsessiontime', $this->table, ["acctsessiontime"]);
        $this->createIndex('ix-acctstarttime-acctstoptime', $this->table, ["acctstarttime", "acctstoptime"]);
        $this->createIndex('ix-nasipaddress', $this->table, ["nasipaddress"]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->table);
    }

}
