<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "radius_accounting".
 *
 * @property int $id
 * @property string $acctsessionid
 * @property string $acctuniqueid
 * @property string $username
 * @property string|null $realm
 * @property string $nasipaddress
 * @property string|null $nasportid
 * @property string|null $nasporttype
 * @property string $acctstarttime
 * @property string|null $acctupdatetime
 * @property string|null $acctstoptime
 * @property int|null $acctinterval
 * @property int|null $acctsessiontime
 * @property string|null $acctauthentic
 * @property string|null $connectinfo_start
 * @property string|null $connectinfo_stop
 * @property int|null $acctinputoctets
 * @property int|null $acctoutputoctets
 * @property string $calledstationid
 * @property string $callingstationid
 * @property string|null $acctterminatecause
 * @property string|null $servicetype
 * @property string|null $framedprotocol
 * @property string $framedipaddress
 * @property string|null $framedipv6address
 * @property string|null $framedipv6prefix
 * @property string|null $framedinterfaceid
 * @property string|null $delegatedipv6prefix
 */
class RadiusAccounting extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'radius_accounting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['username', 'nasipaddress', 'acctstarttime', 'calledstationid', 'callingstationid', 'framedipaddress'], 'required'],
            [['acctstarttime', 'acctupdatetime', 'acctstoptime'], 'safe'],
            [['acctinterval', 'acctsessiontime', 'acctinputoctets', 'acctoutputoctets'], 'integer'],
            [['acctsessionid', 'acctuniqueid', 'username', 'realm', 'nasipaddress', 'nasportid', 'nasporttype', 'acctauthentic', 'connectinfo_start', 'connectinfo_stop', 'calledstationid', 'callingstationid', 'acctterminatecause', 'servicetype', 'framedprotocol', 'framedipaddress', 'framedipv6address', 'framedipv6prefix', 'framedinterfaceid', 'delegatedipv6prefix'], 'string', 'max' => 255],
            [['acctuniqueid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'acctsessionid' => 'Acctsessionid',
            'acctuniqueid' => 'Acctuniqueid',
            'username' => 'Username',
            'realm' => 'Realm',
            'nasipaddress' => 'Nasipaddress',
            'nasportid' => 'Nasportid',
            'nasporttype' => 'Nasporttype',
            'acctstarttime' => 'Acctstarttime',
            'acctupdatetime' => 'Acctupdatetime',
            'acctstoptime' => 'Acctstoptime',
            'acctinterval' => 'Acctinterval',
            'acctsessiontime' => 'Acctsessiontime',
            'acctauthentic' => 'Acctauthentic',
            'connectinfo_start' => 'Connectinfo Start',
            'connectinfo_stop' => 'Connectinfo Stop',
            'acctinputoctets' => 'Acctinputoctets',
            'acctoutputoctets' => 'Acctoutputoctets',
            'calledstationid' => 'Calledstationid',
            'callingstationid' => 'Callingstationid',
            'acctterminatecause' => 'Acctterminatecause',
            'servicetype' => 'Servicetype',
            'framedprotocol' => 'Framedprotocol',
            'framedipaddress' => 'Framedipaddress',
            'framedipv6address' => 'Framedipv6address',
            'framedipv6prefix' => 'Framedipv6prefix',
            'framedinterfaceid' => 'Framedinterfaceid',
            'delegatedipv6prefix' => 'Delegatedipv6prefix',
        ];
    }

    /**
     * {@inheritdoc}
     * @return RadiusAccountingQuery the active query used by this AR class.
     */
    public static function find() {
        return new RadiusAccountingQuery(get_called_class());
    }

    public function getDownload() {
        return !empty($this->acctinputoctets) ? \common\component\Utils::bytesToGB($this->acctinputoctets) : 0;
    }

    public function getUpload() {
        return !empty($this->acctoutputoctets) ? \common\component\Utils::bytesToGB($this->acctoutputoctets) : 0;
    }

    public function getAccount() {
        return $this->hasOne(CustomerAccount::class, ['username' => 'username']);
    }

}
