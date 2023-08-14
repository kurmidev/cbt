<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "complaint".
 *
 * @property int $id
 * @property string $ticketno
 * @property string $username
 * @property int $operator_id
 * @property int $account_id
 * @property int $customer_id
 * @property int $category_id
 * @property int|null $status
 * @property string $opening
 * @property string|null $closing
 * @property int $stages
 * @property string|null $assigned_to
 * @property string|null $extra_details
 * @property int|null $current_assigned
 * @property string|null $opening_date
 * @property string|null $closing_date
 * @property string|null $nextfollowup
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property CustomerAccount $account
 * @property CompCat $category
 * @property Customer $customer
 * @property Operator $operator
 * @property ComplaintDetails[] $complaintDetails
 */
class Complaint extends \common\models\BaseModel {

    public $count;
    const SCENARIO_PENDING = "pending";
    const SCENARIO_CLOSED = "closed";

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'complaint';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['ticketno', 'username', 'operator_id', 'account_id', 'customer_id', 'category_id', 'opening', 'stages', 'current_assigned', 'assigned_to', 'extra_details', 'opening_date'],
            self::SCENARIO_PENDING => ['stages', 'current_assigned', 'assigned_to', 'extra_details', 'closing_date'],
            self::SCENARIO_CLOSED => ['stages', 'current_assigned', 'assigned_to', 'extra_details', 'closing_date'],
            self::SCENARIO_CONSOLE => ['ticketno', 'username', 'operator_id', 'account_id', 'customer_id', 'category_id', 'opening', 'stages', 'assigned_to', 'extra_details', 'opening_date', 'closing_date', 'nextfollowup', 'added_on', 'updated_on'],
            self::SCENARIO_UPDATE => ['ticketno', 'username', 'operator_id', 'account_id', 'customer_id', 'category_id', 'opening', 'stages', 'assigned_to', 'extra_details', 'opening_date', 'closing_date', 'nextfollowup', 'added_on', 'updated_on'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [[ 'username', 'operator_id', 'account_id', 'customer_id', 'category_id', 'opening', 'stages'], 'required'],
            [['operator_id', 'account_id', 'customer_id', 'category_id', 'status', 'stages', 'current_assigned', 'added_by', 'updated_by'], 'integer'],
            [['assigned_to', 'extra_details', 'opening_date', 'closing_date', 'nextfollowup', 'added_on', 'updated_on','ticketno'], 'safe'],
            [['ticketno', 'username', 'opening', 'closing'], 'string', 'max' => 255],
            [['ticketno'], 'unique'],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerAccount::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompCat::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'ticketno' => 'Ticketno',
            'username' => 'Username',
            'operator_id' => 'Operator ID',
            'account_id' => 'Account ID',
            'customer_id' => 'Customer ID',
            'category_id' => 'Category ID',
            'status' => 'Status',
            'opening' => 'Opening',
            'closing' => 'Closing',
            'stages' => 'Stage',
            'assigned_to' => 'Assigned To',
            'extra_details' => 'Extra Details',
            'current_assigned' => 'Current Assigned',
            'opening_date' => 'Opening Date',
            'closing_date' => 'Closing Date',
            'nextfollowup' => 'Nextfollowup',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
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
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|CompCatQuery
     */
    public function getCategory() {
        return $this->hasOne(CompCat::className(), ['id' => 'category_id']);
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
     * Gets query for [[ComplaintDetails]].
     *
     * @return \yii\db\ActiveQuery|ComplaintDetailsQuery
     */
    public function getComplaintDetails() {
        return $this->hasMany(ComplaintDetails::className(), ['complaint_id' => 'id']);
    }

    /**
     * Gets query for [[ComplaintDetails]].
     *
     * @return \yii\db\ActiveQuery|ComplaintDetailsQuery
     */
    public function getCurrentlyAssignedUser() {
        return $this->hasOne(User::className(), ['id' => 'current_assigned']);
    }

    /**
     * {@inheritdoc}
     * @return ComplaintQuery the active query used by this AR class.
     */
    public static function find() {
        return new ComplaintQuery(get_called_class());
    }

    public function beforeSave($insert) {
        if ($insert) {
            $opt = Operator::findOne(['id' => $this->operator_id]);
            if ($opt instanceof Operator) {
                $prefix = $opt->code . "-TK";
                $this->ticketno = empty($this->ticketno) ? $this->generateCode($prefix) : $this->ticketno;
            }
        }
        return parent::beforeSave($insert);
    }

}
