<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\OperatorWallet;
use common\models\CustomerWallet;
use common\models\UploadDocuments;
use common\ebl\Constants as C;

/**
 * This is the model class for table "operator".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $contact_person
 * @property string $mobile_no
 * @property string $telephone_no
 * @property string $email
 * @property string $address
 * @property int $type
 * @property int $mso_id
 * @property int $ro_id
 * @property int $distributor_id
 * @property int $status
 * @property int $state_id
 * @property int $city_id
 * @property string $gst_no
 * @property string $pan_no
 * @property string $tan_no
 * @property int $billing_by
 * @property string $username
 * @property string $is_verified
 * @property array $meta_data
 * @property string $added_on
 * @property string $updated_on
 * @property int $added_by
 * @property int $updated_by
 * @property string $company_logo
 *
 * @property Account[] $accounts
 * @property Location $city
 * @property Location $state
 * @property User $user
 * @property Subscription[] $subscriptions
 * @property Wallet[] $wallets
 * @property Wallet[] $wallets0
 * @property CustomerWallet[] $CustomerWallet
 */
class Operator extends \common\models\BaseModel {

    public $company_logo;

    /**
     * {@inheritdoc}
     * 
     */
    public static function tableName() {
        return 'operator';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['name', 'code', 'contact_person', 'mobile_no', 'address', 'type', 'billing_by', 'username', 'mso_id', 'distributor_id', 'status', 'state_id', 'city_id', 'gst_no', 'pan_no', 'tan_no', 'email', 'telephone_no', 'is_verified', 'ro_id'],
            self::SCENARIO_CONSOLE => ['name', 'code', 'contact_person', 'mobile_no', 'address', 'type', 'billing_by', 'username', 'mso_id', 'distributor_id', 'status', 'state_id', 'city_id', 'gst_no', 'pan_no', 'tan_no', 'email', 'telephone_no', 'is_verified', 'ro_id'],
            self::SCENARIO_UPDATE => ['name', 'code', 'contact_person', 'mobile_no', 'address', 'type', 'billing_by', 'type', 'mso_id', 'distributor_id', 'status', 'state_id', 'city_id', 'gst_no', 'pan_no', 'tan_no', 'email', 'telephone_no', 'is_verified', 'ro_id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'contact_person', 'mobile_no', 'address', 'type', 'billing_by', 'username', 'city_id'], 'required'],
            [['type', 'mso_id', 'distributor_id', 'status', 'state_id', 'city_id', 'billing_by', 'added_by', 'updated_by', 'is_verified', 'ro_id'], 'integer'],
            [['meta_data', 'added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'contact_person', 'mobile_no', 'telephone_no', 'email', 'address', 'gst_no', 'pan_no', 'tan_no', 'username'], 'string', 'max' => 255],
            // [['code'], 'unique'],
            [['username'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['state_id' => 'id']],
            [['username'], 'unique', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['username' => 'username']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'contact_person' => 'Contact Person',
            'mobile_no' => 'Mobile No',
            'telephone_no' => 'Telephone No',
            'email' => 'Email',
            'address' => 'Address',
            'type' => 'Type',
            'mso_id' => 'MSO',
            'distributor_id' => 'Distributor',
            'ro_id' => 'RO',
            'status' => 'Status',
            'state_id' => 'State',
            'city_id' => 'City',
            'gst_no' => 'Gst No',
            'pan_no' => 'Pan No',
            'tan_no' => 'Tan No',
            'billing_by' => 'Billing By',
            'username' => 'Username',
            'meta_data' => 'Meta Data',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
            'is_verified' => 'Is Verfied'
        ];
    }

    /**
     * {@inheritdoc}
     * @return OperatorQuery the active query used by this AR class.
     */
    public static function find() {
        return new OperatorQuery(get_called_class());
    }

    public function beforeValidate() {

        return parent::beforeValidate();
    }

    public function beforeSave($insert) {
        $prefix = C::PREFIX_OPT; //[$this->type];
        $this->code = empty($this->code) ? $this->generateCode($prefix[$this->type]) : $this->code;
        if (empty($this->state_id) && !empty($this->city_id)) {
            $s = Location::findOne($this->city_id);
            if ($s instanceof Location) {
                $this->state_id = $s->state_id;
            }
        }

        if ($this->type != C::OPERATOR_TYPE_MSO) {
            $this->mso_id = User::getMso();
        }

        if ($this->type == C::OPERATOR_TYPE_RO) {
            $this->ro_id = $this->distributor_id = 0;
        }

        if ($this->type == C::OPERATOR_TYPE_DISTRIBUTOR) {
            $this->distributor_id = 0;
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts() {
        return $this->hasMany(Account::className(), ['operator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity() {
        return $this->hasOne(Location::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState() {
        return $this->hasOne(Location::className(), ['id' => 'state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['username' => 'username']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions() {
        return $this->hasMany(Subscription::className(), ['operator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWallets() {
        return $this->hasMany(OperatorWallet::className(), ['operator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerWallet() {
        return $this->hasMany(CustomerWallet::className(), ['operator_id' => 'id']);
    }

    public function getMso() {
        return $this->hasOne(Operator::class, ['id' => 'mso_id']);
    }

    public function getRo() {
        return $this->hasOne(Operator::class, ['id' => 'ro_id']);
    }

    public function getDistributor() {
        return $this->hasOne(Operator::class, ['id' => 'distributor_id']);
    }

    public function getPlanTypes() {
        return C::RATE_TYPE_BOUQUET;
    }

    public function getBouquet() {
        return $this->hasMany(OperatorRates::class, ['operator_id' => 'id'])
                        ->with(['bouquet'])->andWhere(['type' => C::RATE_TYPE_BOUQUET]);
    }

    public function getStatic() {
        return $this->hasMany(OperatorRates::class, ['operator_id' => 'id'])
                        ->with(['bouquet'])->andWhere(['type' => C::RATE_TYPE_STATICIP]);
    }

    public function getLogo() {
        $ud = UploadDocuments::findOne(['type' => UploadDocuments::OPT_LOGO, 'model_name' => self::tableName(), 'model_id' => $this->id]);
        if ($ud instanceof UploadDocuments) {
            return $ud->document['content'];
        }
        return NULL;
    }

    public function getCrAmount() {
        return $this->hasMany(OperatorWallet::className(), ['operator_id' => 'id'])
                        ->andWhere(['trans_type' => C::TRANSACTION_TYPE_OPT_CREDIT])
                        ->select(['cr_amount' => "sum(amount)", "cr_tax" => "sum(tax)", "total" => "sum(amount+tax)"])
                        ->groupBy(['operator_id']);
    }

    public function getDrAmount() {
        return $this->hasMany(OperatorWallet::className(), ['operator_id' => 'id'])
                        ->andWhere(['trans_type' => C::TRANSACTION_TYPE_OPT_DEBIT])
                        ->select(['dr_amount' => "sum(amount)", "dr_tax" => "sum(tax)", "total" => "sum(amount+tax)"])
                        ->groupBy(['operator_id']);
    }

    public function getBalance() {
        $cr = !empty($this->crAmount[0]) ? $this->crAmount[0]['total'] : 0;
        $dr = !empty($this->drAmount[0]) ? $this->drAmount[0]['total'] : 0;
        return $cr - $dr;
    }

    public function isBalanceAvailable($amount) {
        return $this->balance > $amount;
    }

    public function getLastBill($billmonth = "") {
        if (!empty($billmonth)) {
            return OperatorBill::find()->andWhere(['operator_id' => $this->id, 'bill_month' => $billmonth])
                            ->orderBy(['id' => SORT_DESC])->one();
        }

        return OperatorBill::find()->where(['operator_id' => $this->id])->orderBy(['id' => SORT_DESC])->one();
    }

    public function getBilledBy() {
        return $this->hasOne(Operator::class, ['id' => 'billing_by']);
    }

    public function getWallet() {
        return $this->hasMany(OperatorWallet::class, ['operator_id' => 'id']);
    }

}
