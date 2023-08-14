<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;
use common\models\OptPaymentReconsile;
use common\models\CustomerWallet;

/**
 * This is the model class for table "wallet".
 *
 * @property int $id
 * @property int $cr_operator_id
 * @property int $dr_operator_id
 * @property string $amount
 * @property string $tax
 * @property int $transaction_id
 * @property int $trans_type
 * @property string $receipt_no
 * @property string $balance
 * @property string $remark
 * @property array $meta_data
 * @property string $added_on
 * @property string $updated_on
 * @property int $cancel_id
 * @property int $bounce_id
 * @property int $added_by
 * @property int $updated_by
 * @property int $operator_id
 * @property int $operator_id
 * @property int $operator_id
 *
 * @property Operator $crOperator
 * @property Operator $drOperator
 * @property WalletTransaction $transaction
 */
class OperatorWallet extends \common\models\BaseModel {

    public $counts;
    public $rate;
    public $total;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'operator_wallet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cr_operator_id', 'dr_operator_id', 'transaction_id', 'trans_type', 'added_by', 'updated_by', 'operator_id'], 'integer'],
            [['amount', 'tax', 'balance'], 'number'],
            [['trans_type'], 'required'],
            [['meta_data', 'added_on', 'updated_on', 'bounce_id', 'cancel_id',], 'safe'],
            [['receipt_no', 'remark'], 'string', 'max' => 255],
            [['cr_operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['cr_operator_id' => 'id']],
            [['dr_operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operator::className(), 'targetAttribute' => ['dr_operator_id' => 'id']],
            [['transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerWallet::className(), 'targetAttribute' => ['transaction_id' => 'id']],
        ];
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'cr_operator_id', 'dr_operator_id', 'transaction_id', 'trans_type', 'added_by', 'updated_by', 'operator_id', 'amount', 'tax', 'balance', 'meta_data', 'receipt_no', 'remark'],
            self::SCENARIO_CONSOLE => ['id', 'cr_operator_id', 'dr_operator_id', 'transaction_id', 'trans_type', 'added_by', 'updated_by', 'operator_id', 'amount', 'tax', 'balance', 'meta_data', 'receipt_no', 'remark'],
            self::SCENARIO_UPDATE => ['cr_operator_id', 'dr_operator_id', 'transaction_id', 'trans_type', 'added_by', 'updated_by', 'operator_id', 'amount', 'tax', 'balance', 'meta_data', 'receipt_no', 'remark', 'bounce_id', 'cancel_id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cr_operator_id' => 'Cr Operator ID',
            'dr_operator_id' => 'Dr Operator ID',
            'amount' => 'Amount',
            'tax' => 'Tax',
            'transaction_id' => 'Transaction ID',
            'trans_type' => 'Type',
            'receipt_no' => 'Receipt No',
            'balance' => 'Balance',
            'remark' => 'Remark',
            'bounce_id' => "Bounce Details",
            'cancel_id' => "Cancel Details",
            'meta_data' => 'Meta Data',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
            'operator_id' => 'Operator',
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            $this->receipt_no = !empty($this->receipt_no) ? $this->receipt_no : $this->genReceiptNo($this->trans_type);
            self::updateAll(['receipt_no' => $this->receipt_no], ['id' => $this->id]);
            if (in_array($this->trans_type, C::TRANSACTION_RECONSILE_RECONSILE) && OPERATOR_RECONCILIATION && $this->meta_data['pay_mode'] != C::PAY_MODE_CASH && OPT_RECONCILLATION) {
                $this->addToReconcile();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrOperator() {
        return $this->hasOne(Operator::className(), ['id' => 'cr_operator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrOperator() {
        return $this->hasOne(Operator::className(), ['id' => 'dr_operator_id']);
    }

    public function getOperator() {
        return $this->hasOne(Operator::className(), ['id' => 'operator_id']);
    }

    public function getCustomerWallet() {
        return $this->hasOne(CustomerWallet::class, ['id' => "transaction_id"])->with(['accountPlan']);
    }

//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getTransaction() {
//        return $this->hasOne(WalletTransaction::className(), ['id' => 'transaction_id']);
//    }

    /**
     * {@inheritdoc}
     * @return WalletQuery the active query used by this AR class.
     */
    public static function find() {
        return new OperatorWalletQuery(get_called_class());
    }

    public function beforeSave($insert) {
        if ($insert) {
            $opt = Operator::findOne($this->operator_id);
            $this->balance = in_array($this->trans_type, C::TRANSACTION_TYPE_OPT_CREDIT) ?
                    $opt->balance + $this->amount + $this->tax : $opt->balance - ($this->amount + $this->tax);
        }

        return parent::beforeSave($insert);
    }

    public function genReceiptNo($t) {
        $p = \common\component\Utils::getValuesFromArray(C::LABEL_TRANS_PREFIX, $t);
        $p = !empty($p) ? $p :
                (in_array($t, C::TRANSACTION_TYPE_OPT_CREDIT) ? C::PREFIX_CREDIT :
                C::PREFIX_DEBIT);
        $c = CodeSequence::getSequence($p);
        return $p . $c;
    }

    public function addToReconcile(): bool {


        $model = OptPaymentReconsile::findOne(['receipt_no' => $this->receipt_no, 'wallet_id' => $this->id]);
        if (!$model instanceof OptPaymentReconsile) {
            $model = new OptPaymentReconsile(['scenario' => self::SCENARIO_CREATE]);
            $model->inst_no = !empty($this->meta_data['instrument_nos']) ? $this->meta_data['instrument_nos'] : $this->receipt_no;
            $model->inst_date = $this->meta_data['instrument_date'];
            $model->bank = $this->meta_data['instrument_name'];
            $model->receipt_no = $this->receipt_no;
            $model->wallet_id = $this->id;
            $model->amount = $this->amount;
            $model->tax = empty($this->tax) ? 0 : $this->tax;
            $model->status = C::INST_PENDING;
            $model->remark = $this->remark;
            if ($model->validate() && $model->save()) {
                return true;
            }
        }
        return false;
    }

}
