<?php

namespace common\models;

use Yii;
use common\ebl\Constants as C;

/**
 * Model opt_payment_reconsile property.
 *
 * @property integer $id
 * @property string $inst_no
 * @property string $inst_date
 * @property string $bank
 * @property string $receipt_no
 * @property integer $wallet_id
 * @property string $amount
 * @property string $tax
 * @property integer $status
 * @property string $deposited_bank
 * @property integer $deposited_by
 * @property string $desposited_on
 * @property string $realized_on
 * @property integer $realised_by
 * @property string $remark
 * @property string $added_on
 * @property string $updated_on
 * @property integer $added_by
 * @property integer $updated_by
 *
 * @property Wallet $wallet
 */
class OptPaymentReconsile extends \common\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'opt_payment_reconsile';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'inst_no', 'inst_date', 'bank', 'receipt_no', 'wallet_id', 'amount', 'tax', 'status', 'deposited_bank', 'deposited_by', 'desposited_on', 'realized_on', 'realised_by', 'remark', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_CONSOLE => ['id', 'inst_no', 'inst_date', 'bank', 'receipt_no', 'wallet_id', 'amount', 'tax', 'status', 'deposited_bank', 'deposited_by', 'desposited_on', 'realized_on', 'realised_by', 'remark', 'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_UPDATE => ['id', 'inst_no', 'inst_date', 'bank', 'receipt_no', 'wallet_id', 'amount', 'tax', 'status', 'deposited_bank', 'deposited_by', 'desposited_on', 'realized_on', 'realised_by', 'remark', 'added_on', 'updated_on', 'added_by', 'updated_by'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) {
        $keys = array_keys($changedAttributes);

        if (in_array("status", $keys)) {
            if (in_array($this->status, [C::RECONSILE_STATUS_CANCELLED, C::RECONSILE_STATUS_BOUNCE])) { //Reverse whole amount
                $this->reverseCharges();
            }

            if (in_array($this->status, [C::RECONSILE_STATUS_BOUNCE]) && OPT_BOUNCE_CHARGES) { // Raise bounce charges
                $this->raiseBounceCharges();
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['inst_date', 'wallet_id', 'status', 'amount', 'inst_no', 'bank', 'receipt_no'], 'required'],
            [['desposited_on', 'realized_on', 'added_on', 'updated_on'], 'safe'],
            [['deposited_by', 'realised_by', 'added_by', 'updated_by', 'bounce_id', 'cancel_id',], 'integer'],
            [['amount', 'tax'], 'number'],
            [['inst_no', 'bank', 'receipt_no', 'deposited_bank', 'remark'], 'string', 'max' => 255],
            [['inst_no', 'receipt_no', 'wallet_id'], 'unique', 'targetAttribute' => ['inst_no', 'receipt_no', 'wallet_id'], 'message' => 'The combination of Inst No, Receipt No and Wallet ID has already been taken.'],
            [['wallet_id'], 'exist', 'skipOnError' => true, 'targetClass' => OperatorWallet::className(), 'targetAttribute' => ['wallet_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWallet() {
        return $this->hasOne(OperatorWallet::className(), ['id' => 'wallet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCancelWallet() {
        return $this->hasOne(OperatorWallet::className(), ['id' => 'cancel_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBounceWallet() {
        return $this->hasOne(OperatorWallet::className(), ['id' => 'bounce_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeposited() {
        return $this->hasOne(User::className(), ['id' => 'deposited_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRealised() {
        return $this->hasOne(User::className(), ['id' => 'realised_by']);
    }

    public function getDeposited_by_lbl() {
        return !empty($this->deposited) ? $this->deposited->name : "";
    }

    public function getRealised_by_lbl() {
        return !empty($this->realised) ? $this->realised->name : "";
    }

    /**
     * with
     * @return type
     */
    function defaultWith() {
        return [];
    }

    static function extraFieldsWithConf() {
        $retun = parent::extraFieldsWithConf();
        return $retun;
    }

    /**
     * @inheritdoc
     */
    public function fields() {
        $fields = [
            'id',
            'inst_no',
            'inst_date',
            'bank',
            'receipt_no',
            'wallet_id',
            'amount',
            'tax',
            'status',
            'deposited_bank',
            'deposited_by',
            'desposited_on',
            'realized_on',
            'realised_by',
            'remark',
            'bounce_id',
            'cancel_id',
            'added_on',
            'updated_on',
            'added_by',
            'updated_by',
        ];

        return array_merge(parent::fields(), $fields);
    }

    /**
     * @inheritdoc
     */
    public function extraFields() {
        $fields = parent::extraFields();

        return $fields;
    }

    public function getStatus_label() {
        return !empty(C::LABEL_RECONSILE_STATUS[$this->status]) ? C::LABEL_RECONSILE_STATUS[$this->status] : $this->status;
    }

    /**
     * @inheritdoc
     * @return OptPaymentReconsileQuery the active query used by this AR class.
     */
    /* public static function find(){
      return new OptPaymentReconsileQuery(get_called_class())->applycache();
      }
     */

    public function reverseCharges() {
        $model = OperatorWallet::findOne(['cancel_id' => $this->wallet_id, 'trans_type' => [C::TRANS_DR_BOUNCE_ON_RECON, C::TRANS_DR_CANCEL_ON_RECON]]);
        if (!$model instanceof OperatorWallet) {
            $model = new OperatorWallet(['scenario' => OperatorWallet::SCENARIO_CREATE]);
            $model->cr_operator_id = null;
            $model->dr_operator_id = $this->wallet->operator_id;
            $model->operator_id = $this->wallet->operator_id;
            $model->amount = $this->amount;
            $model->tax = $this->tax;
            $model->trans_type = $this->status == C::RECONSILE_STATUS_CANCELLED ? C::TRANS_DR_CANCEL_ON_RECON : C::TRANS_DR_BOUNCE_ON_RECON;
            $model->remark = "Marked " . ( $this->status == C::RECONSILE_STATUS_CANCELLED ? "Cancelled" : "Bounce") . " by " . (User::loggedInUserName());
            $model->meta_data = $this->wallet->meta_data;
            if ($model->validate() && $model->save()) {
                OperatorWallet::updateAll(['cancel_id' => $model->id], ['id' => $this->wallet_id]);
                OptPaymentReconsile::updateAll(['cancel_id' => $model->id], ['id' => $this->id]);
                return true;
            }
        }
        return false;
    }

    public function raiseBounceCharges() {
        $model = OperatorWallet::findOne(['bounce_id' => $this->wallet_id, 'trans_type' => [C::TRANS_DR_BOUNCE_CHARGES]]);
        if (!$model instanceof OperatorWallet) {
            $model = new OperatorWallet(['scenario' => OperatorWallet::SCENARIO_CREATE]);
            $model->cr_operator_id = null;
            $model->dr_operator_id = $this->wallet->operator_id;
            $model->operator_id = $this->wallet->operator_id;
            $model->amount = BOUNCE_CHARGES;
            $model->tax = $this->tax;
            $model->trans_type = C::TRANS_DR_BOUNCE_CHARGES;
            $model->remark = "Charging bounce fine as this transaction is marked as bounce by " . (User::loggedInUserName());
            $model->meta_data = $this->wallet->meta_data;
            if ($model->validate() && $model->save()) {
                OperatorWallet::updateAll(['bounce_id' => $model->id], ['id' => $this->wallet_id]);
                OptPaymentReconsile::updateAll(['bounce_id' => $model->id], ['id' => $this->id]);
                return true;
            }
        }
        return false;
    }

}
