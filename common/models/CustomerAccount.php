<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * This is the model class for table "customer_account".
 *
 * @property int $id
 * @property string|null $cid
 * @property int|null $customer_id
 * @property string|null $username
 * @property string|null $password
 * @property int $operator_id
 * @property int|null $road_id
 * @property string|null $building_id
 * @property int|null $router_type
 * @property string|null $mac_address
 * @property string|null $static_ip
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $status
 * @property int|null $account_types
 * @property int|null $is_auto_renew
 * @property string|null $meta_data
 * @property string|null $current_plan
 * @property int|null $prospect_id
 * @property int|null $history
 * @property int|null $remark
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property Customer $customer
 * @property Operator $operator
 * @property CustomerAccountBouquet[] $CustomerAccountBouquets
 */
class CustomerAccount extends \common\models\BaseModel {

    public $active, $inactive, $expired;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'customer_account';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['cid', 'customer_id', 'username', 'password', 'operator_id', 'road_id', 'building_id', 'router_type', 'mac_address', 'static_ip', 'start_date', 'end_date', 'status', 'account_types', 'is_auto_renew', 'meta_data', 'current_plan', 'prospect_id', 'history', 'remark'],
            self::SCENARIO_CONSOLE => ['cid', 'customer_id', 'username', 'password', 'operator_id', 'road_id', 'building_id', 'router_type', 'mac_address', 'static_ip', 'start_date', 'end_date', 'status', 'account_types', 'is_auto_renew', 'meta_data', 'current_plan', 'prospect_id', 'history', 'remark'],
            self::SCENARIO_UPDATE => ['cid', 'customer_id', 'username', 'password', 'operator_id', 'road_id', 'building_id', 'router_type', 'mac_address', 'static_ip', 'start_date', 'end_date', 'status', 'account_types', 'is_auto_renew', 'meta_data', 'current_plan', 'prospect_id', 'history', 'remark'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['customer_id', 'operator_id', 'road_id', 'router_type', 'status', 'account_types', 'is_auto_renew', 'prospect_id', 'added_by', 'updated_by', 'building_id'], 'integer'],
            [['operator_id', 'road_id', 'status', 'account_types', 'is_auto_renew'], 'required'],
            [['mac_address', 'start_date', 'end_date', 'meta_data', 'current_plan', 'added_on', 'updated_on', 'history', 'remark'], 'safe'],
            [['cid', 'username', 'password', 'static_ip'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['operator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cid' => 'Cid',
            'customer_id' => 'Customer ID',
            'username' => 'Username',
            'password' => 'Password',
            'operator_id' => 'Operator ID',
            'road_id' => 'Road ID',
            'building_id' => 'Building ID',
            'router_type' => 'Router Type',
            'mac_address' => 'Mac Address',
            'static_ip' => 'Static Ip',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'account_types' => 'Account Types',
            'is_auto_renew' => 'Is Auto Renew',
            'meta_data' => 'Meta Data',
            'current_plan' => 'Current Plan',
            'prospect_id' => 'Prospect ID',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|CustomerQuery
     */
    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Operator]].
     *
     * @return \yii\db\ActiveQuery|OperatorQuery
     */
    public function getOperator() {
        return $this->hasOne(Operator::className(), ['id' => 'operator_id']);
    }

    /**
     * Gets query for [[CustomerAccountBouquets]].
     *
     * @return \yii\db\ActiveQuery|CustomerAccountBouquetQuery
     */
    public function getCustomerBouquet() {
        return $this->hasMany(CustomerBouquet::className(), ['account_id' => 'id'])->orderBy(['id' => SORT_ASC]);
    }

    /**
     * Gets query for [[Location]].
     *
     * @return \yii\db\ActiveQuery|OperatorQuery
     */
    public function getRoad() {
        return $this->hasOne(Location::className(), ['id' => 'road_id']);
    }

    /**
     * Gets query for [[Location]].
     *
     * @return \yii\db\ActiveQuery|OperatorQuery
     */
    public function getBuilding() {
        return $this->hasOne(Location::className(), ['id' => 'building_id']);
    }

    /**
     * {@inheritdoc}
     * @return CustomerAccountQuery the active query used by this AR class.
     */
    public static function find() {
        return new CustomerAccountQuery(get_called_class());
    }

    public function getActiveBase() {
        return $this->hasMany(CustomerAccountBouquet::class, ['account_id' => 'id'])
                        ->andWhere(['status' => C::STATUS_ACTIVE, 'bouquet_type' => C::PLAN_TYPE_BASE])
                        ->andWhere(['>', 'end_date', date("Y-m-d")]);
    }

    public function getActiveAddons() {
        return $this->hasMany(CustomerAccountBouquet::class, ['account_id' => 'id'])
                        ->andWhere(['status' => C::STATUS_ACTIVE, 'plan_type' => C::PLAN_TYPE_ADDONS])
                        ->andWhere(['>', 'end_date', date("Y-m-d")]);
    }

    public function getActivePlans() {
        return $this->hasMany(CustomerAccountBouquet::class, ['account_id' => 'id'])->alias('p')
                        ->andWhere(['p.status' => C::STATUS_ACTIVE])
                        ->andWhere(['>', 'p.end_date', date("Y-m-d")]);
    }

    public function getCurrentPlans() {
        return $this->hasMany(CustomerAccountBouquet::class, ['account_id' => 'id'])
                        ->andWhere(['end_date' => $this->end_date]);
    }

    public function getIpAddress() {
        return $this->static_ip;
    }

    public function getCustomerWallet() {
        return $this->hasMany(CustomerWallet::class, ['account_id' => 'id']);
    }

    public function getCrAmount() {
        return $this->hasMany(CustomerWallet::className(), ['account_id' => 'id'])
                        ->andWhere(['trans_type' => C::TRANSACTION_TYPE_SUB_CREDIT])
                        ->select(['cr_amount' => "sum(amount)", "cr_tax" => "sum(tax)", "total" => "sum(amount+tax)"])
                        ->groupBy(['operator_id'])->asArray()->all();
    }

    public function getDrAmount() {
        return $this->hasMany(CustomerWallet::className(), ['account_id' => 'id'])
                        ->andWhere(['trans_type' => C::TRANSACTION_TYPE_SUB_DEBIT])
                        ->select(['dr_amount' => "sum(amount)", "dr_tax" => "sum(tax)", "total" => "sum(amount+tax)"])
                        ->groupBy(['operator_id'])->asArray()->all();
    }

    public function getBalance() {
        $cr = !empty($this->crAmount[0]) ? $this->crAmount[0]['total'] : 0;
        $dr = !empty($this->drAmount[0]) ? $this->drAmount[0]['total'] : 0;
        return $dr - $cr;
    }

    public function isBalanceAvailable($amount) {
        return $this->balance > $amount;
    }

    public function getCustomerName() {
        return !empty($this->customer) ? $this->customer->name : "";
    }

    public function afterSave($insert, $changedAttributes) {
        if (!empty($changedAttributes)) {
            $this->checkOperatorChanges($changedAttributes);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function checkOperatorChanges($changedAttributes) {
        $updateSet = [];
        if (!empty($changedAttributes['operator_id'])) {
            $updateSet['operator_id'] = $this->operator_id;
        }
        if (!empty($changedAttributes['building_id'])) {
            $updateSet['building_id'] = $this->building_id;
        }
        if (!empty($changedAttributes['road_id'])) {
            $updateSet['road_id'] = $this->road_id;
        }
        if (!empty($updateSet)) {
            Customer::updateAll($updateSet, ['id' => $this->customer_id]);
        }
    }

    public function getLastBill($billmonth = "") {
        return OperatorBill::find()->where(['account_id' => $this->id])
                        ->andFilterWhere(['bill_month' => $billmonth])->orderBy(['id' => SORT_DESC])->one();
    }

    public function getRadiusAccounting() {
        return $this->hasMany(RadiusAccounting::class, ['username' => 'username']);
    }

    public function getComplaint() {
        return $this->hasMany(Complaint::class, ['account_id' => 'id']);
    }

    public function getOpenComplaint() {
        return $this->hasMany(Complaint::class, ['account_id' => 'id'])->alias('c')->andWhere(['c.stages' => C::COMPLAINT_PENDING]);
    }

    public function getClosedComplaint() {
        return $this->hasMany(Complaint::class, ['account_id' => 'id'])->alias('c')->andWhere(['c.stages' => C::COMPLAINT_CLOSED]);
    }

    public function getLastPayment() {
        return $this->hasMany(CustomerWallet::class, ['account_id' => 'id'])->collectionEntry()->orderBy(['id' => SORT_DESC])->one();
    }

    public function getLastBasePlan() {
        $subQuery = CustomerAccountBouquet::find()
                ->andWhere(['account_id' => $this->id, 'plan_type' => C::PLAN_TYPE_BASE])
                ->select(['end_date' => 'max(end_date)']);
        return CustomerAccountBouquet::find()
                        ->andWhere(['account_id' => $this->id, 'end_date' => $subQuery, 'plan_type' => C::PLAN_TYPE_BASE])->one();
    }

}
