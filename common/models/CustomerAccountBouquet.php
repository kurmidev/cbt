<?php

namespace common\models;

use Yii;
use common\component\Utils as U;
use common\ebl\Constants as C;
use common\models\CustomerWallet;

/**
 * This is the model class for table "customer_account_plan".
 *
 * @property int $id
 * @property int|null $account_id
 * @property int|null $customer_id
 * @property int $operator_id
 * @property int|null $road_id
 * @property string|null $building_id
 * @property int|null $router_type
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $cal_end_date
 * @property int|null $status
 * @property int $bouquet_id
 * @property int $bouquet_type
 * @property int|null $is_refundable
 * @property string|null $meta_data
 * @property int|null $rate_id
 * @property float|null $per_day_amount
 * @property float|null $per_day_mrp
 * @property float|null $amount
 * @property float|null $tax
 * @property float|null $mrp
 * @property float|null $mrp_tax
 * @property float|null $refund_amount
 * @property float|null $refund_tax
 * @property float|null $refund_mrp
 * @property float|null $refund_mrp_tax
 * @property float|null $voucher_amount
 * @property float|null $vocuher_tax
 * @property int|null $vouhcer_id
 * @property string|null $upload
 * @property string|null $download
 * @property string|null $remark
 * @property int|null $renewal_type
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property CustomerAccount $account
 * @property Customer $customer
 * @property Operator $operator
 */
class CustomerAccountBouquet extends \common\models\BaseModel {

    public $cnt;
    public $activeCnt;
    public $inactiveCnt;
    public $expiry;
    public $active;
    public $inactive;
    public $trans_grp;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'customer_account_bouquet';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['account_id', 'customer_id', 'operator_id', 'road_id', 'building_id', 'router_type', 'start_date', 'end_date', 'cal_end_date', 'status', 'bouquet_id', 'bouquet_type', 'is_refundable', 'meta_data', 'rate_id', 'per_day_amount', 'per_day_mrp', 'amount', 'tax', 'mrp', 'mrp_tax', 'refund_amount', 'remark', 'renewal_type', 'voucher_amount', 'voucher_tax', 'voucher_id', 'trans_grp'],
            self::SCENARIO_CONSOLE => ['account_id', 'customer_id', 'operator_id', 'road_id', 'building_id', 'router_type', 'start_date', 'end_date', 'cal_end_date', 'status', 'bouquet_id', 'bouquet_type', 'is_refundable', 'meta_data', 'rate_id', 'per_day_amount', 'per_day_mrp', 'amount', 'tax', 'mrp', 'mrp_tax', 'refund_amount', 'refund_tax', 'refund_mrp', 'refund_mrp_tax', 'upload', 'download', 'remark', 'renewal_type', 'trans_grp'],
            self::SCENARIO_UPDATE => ['operator_id', 'road_id', 'building_id', 'router_type', 'status', 'meta_data', 'refund_amount', 'refund_tax', 'refund_mrp', 'refund_mrp_tax', 'upload', 'download', 'remark', 'voucher_amount', 'voucher_tax', 'voucher_id', 'trans_grp'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['account_id', 'customer_id', 'operator_id', 'road_id', 'router_type', 'status', 'bouquet_id', 'bouquet_type', 'is_refundable', 'rate_id', 'renewal_type', 'added_by', 'updated_by', 'building_id'], 'integer'],
            [['operator_id', 'bouquet_id', 'bouquet_type'], 'required'],
            [['start_date', 'end_date', 'cal_end_date', 'meta_data', 'added_on', 'updated_on', 'voucher_amount', 'voucher_tax', 'voucher_id', 'trans_grp'], 'safe'],
            [['per_day_amount', 'per_day_mrp', 'amount', 'tax', 'mrp', 'mrp_tax', 'refund_amount', 'refund_tax', 'refund_mrp', 'refund_mrp_tax'], 'number'],
            [['upload', 'download', 'remark'], 'string', 'max' => 255],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerAccount::className(), 'targetAttribute' => ['account_id' => 'id']],
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
            'account_id' => 'Account ID',
            'customer_id' => 'Customer ID',
            'operator_id' => 'Operator ID',
            'road_id' => 'Road ID',
            'building_id' => 'Building ID',
            'router_type' => 'Router Type',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'cal_end_date' => 'Cal End Date',
            'status' => 'Status',
            'bouquet_id' => 'Bouquet ID',
            'bouquet_type' => 'Bouquet Type',
            'is_refundable' => 'Is Refundable',
            'meta_data' => 'Meta Data',
            'rate_id' => 'Rate ID',
            'per_day_amount' => 'Per Day Amount',
            'per_day_mrp' => 'Per Day Mrp',
            'amount' => 'Amount',
            'tax' => 'Tax',
            'mrp' => 'Mrp',
            'mrp_tax' => 'Mrp Tax',
            'refund_amount' => 'Refund Amount',
            'refund_tax' => 'Refund Tax',
            'refund_mrp' => 'Refund Mrp',
            'refund_mrp_tax' => 'Refund Mrp Tax',
            'upload' => 'Upload',
            'download' => 'Download',
            'remark' => 'Remark',
            'renewal_type' => 'Renewal Type',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
            'voucher_amount' => "Voucher Amount",
            'voucher_tax' => "Voucher Tax",
            'voucher_id' => "Vocuher"
        ];
    }

    /**
     * Gets query for [[Account]].
     *
     * @return \yii\db\ActiveQuery|CustomerAccountQuery
     */
    public function getAccount() {
        return $this->hasOne(CustomerAccount::className(), ['id' => 'account_id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|CustomerQuery
     */
    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getBouquet() {
        return $this->hasOne(Bouquet::className(), ['id' => 'bouquet_id']);
    }

    public function getVoucher() {
        return $this->hasOne(VoucherMaster::className(), ['id' => 'voucher_id']);
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
     * {@inheritdoc}
     * @return CustomerAccountBouquetQuery the active query used by this AR class.
     */
    public static function find() {
        return new CustomerAccountBouquetQuery(get_called_class());
    }

    public function getRefundData() {
        $start_date = U::getMaxDates($this->start_date, date("Y-m-d", strtotime("+1 days")));
        $end_date = $this->end_date;
        $left_days = U::dateDiff($start_date, $end_date);
        $amount = $this->per_day_amount * $left_days;
        $mrp = $this->per_day_mrp * $left_days;
        $tax = U::calculateTax($amount);
        $mrp_tax = U::calculateTax($mrp);
        return [
            'amount' => $amount,
            'tax' => $tax,
            'mrp' => $mrp,
            'mrp_tax' => $mrp_tax,
            'days_left' => $left_days,
            'per_day_mrp' => $this->per_day_mrp,
            'per_day_amount' => $this->per_day_amount,
            'plan_name' => $this->plan->name,
            'bouquet_type' => $this->bouquet_type,
            'bouquet_id' => $this->bouquet_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }

    public function getPlanTypeLabel() {
        return !empty(C::LABEL_PLAN_TYPE[$this->bouquet_type]) ? C::LABEL_PLAN_TYPE[$this->bouquet_type] : "";
    }

    public function getRefundAmount() {
        $d = $this->refundData;
        return $d['amount'] + $d['tax'];
    }

    public function getRefundMrp() {
        $d = $this->refundData;
        return $d['mrp'] + $d['mrp_tax'];
    }

    public function getLeftDays() {
        $d = $this->refundData;
        return $d['days_left'];
    }

    public function debitCustomer() {
        $model = new CustomerWallet(['scenario' => CustomerWallet::SCENARIO_CREATE]);
        $model->subscriber_id = $this->customer_id;
        $model->account_id = $this->account_id;
        $model->operator_id = $this->operator_id;
        $model->trans_type = C::TRANS_DR_SUBSCRIPTION_CHARGES;
        $model->amount = $this->mrp;
        $model->tax = $this->mrp_tax;
        $model->trans_id = $this->bouquet_id;
        $model->start_date = $this->start_date;
        $model->end_date = $this->end_date;
        $model->remark = $this->remark;
        $model->meta_data = $this->meta_data['debit'];
        $model->trans_grp = $this->trans_grp;
        if ($model->validate() && $model->save()) {
            return $model;
        }
        return false;
    }

    public function debitOperatorWallet() {
        $model = new OperatorWallet(['scenario' => OperatorWallet::SCENARIO_CREATE]);
        $model->dr_operator_id = $this->operator_id;
        $model->cr_operator_id = null;
        $model->operator_id = $this->operator_id;
        $model->amount = $this->amount;
        $model->tax = $this->tax;
        $model->transaction_id = $this->id;
        $model->trans_type = C::TRANS_DR_SUBSCRIPTION_CHARGES;
        $model->remark = $this->remark;
        $model->meta_data = $this->meta_data['debit'];
        if ($model->validate() && $model->save()) {
            return $model;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            if (!empty($this->amount)) {
                $this->debitOperatorWallet();
            }
            if (!empty($this->mrp)) {
                $this->debitCustomer();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

}
