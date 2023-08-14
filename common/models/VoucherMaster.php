<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "voucher_master".
 *
 * @property int $id
 * @property string|null $coupon
 * @property int|null $operator_id
 * @property int|null $account_id
 * @property string|null $username
 * @property string|null $expiry_date
 * @property int|null $opt_wallet_id
 * @property int|null $cus_wallet_id
 * @property int|null $status
 * @property int|null $is_locked
 * @property float|null $opt_amount
 * @property float|null $cust_amount
 * @property int|null $plan_id
 * @property string|null $remark
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property CustomerAccount $account
 * @property Operator $operator
 */
class VoucherMaster extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'voucher_master';
    }

    public function scenarios() {
        return [
            self::SCENARIO_CREATE => ['operator_id', 'expiry_date', 'coupon', 'status', 'plan_id'],
            self::SCENARIO_UPDATE => ['account_id', 'opt_wallet_id', 'cus_wallet_id', 'status', 'is_locked']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['operator_id', 'account_id', 'opt_wallet_id', 'cus_wallet_id', 'status', 'is_locked', 'plan_id', 'added_by', 'updated_by'], 'integer'],
            [['expiry_date', 'added_on', 'updated_on'], 'safe'],
            [['opt_amount', 'cust_amount'], 'number'],
            [['coupon', 'username', 'remark'], 'string', 'max' => 255],
            [['coupon'], 'unique'],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerAccount::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['operator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'coupon' => 'Coupon',
            'operator_id' => 'Operator ID',
            'account_id' => 'Account ID',
            'username' => 'Username',
            'expiry_date' => 'Expiry Date',
            'opt_wallet_id' => 'Opt Wallet ID',
            'cus_wallet_id' => 'Cus Wallet ID',
            'status' => 'Status',
            'is_locked' => 'Is Locked',
            'opt_amount' => 'Opt Amount',
            'cust_amount' => 'Cust Amount',
            'plan_id' => 'Bouquet',
            'remark' => 'Remark',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[PlanMaster]].
     *
     * @return \yii\db\ActiveQuery|PlanMasterQuery
     */
    public function getPlan() {
        return $this->hasOne(PlanMaster::className(), ['id' => 'plan_id']);
    }

    public function getName() {
        return "{$this->coupon} Rate:{$this->opt_amount} MRP:{$this->cust_amount}";
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
     * Gets query for [[Account]].
     *
     * @return \yii\db\ActiveQuery|CustommerAccountQuery
     */
    public function getAccount() {
        return $this->hasOne(CustomerAccount::className(), ['id' => 'account_id']);
    }

    /**
     * Gets query for [[OperatorWallet]].
     *
     * @return \yii\db\ActiveQuery|OperatorWalletQuery
     */
    public function getOperatorWallet() {
        return $this->hasOne(OperatorWallet::className(), ['id' => 'opt_wallet_id']);
    }

    /**
     * Gets query for [[CustomerWallet]].
     *
     * @return \yii\db\ActiveQuery|CustomerWalletQuery
     */
    public function getCustomerWallet() {
        return $this->hasOne(CustomerWallet::className(), ['id' => 'cus_wallet_id']);
    }

    /**
     * {@inheritdoc}
     * @return VoucherMasterQuery the active query used by this AR class.
     */
    public static function find() {
        return new VoucherMasterQuery(get_called_class());
    }

}
