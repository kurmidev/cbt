<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "complaint_details".
 *
 * @property int $id
 * @property int $account_id
 * @property int $complaint_id
 * @property string $comments
 * @property string|null $nextfollowup
 * @property int|null $stage
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property CustomerAccount $account
 * @property Complaint $complaint
 */
class ComplaintDetails extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'complaint_details';
    }

    public function scenarios() {
        return [
            self::SCENARIO_CREATE=>["account_id","complaint_id","comments",'stages','nextfollowup']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['account_id', 'complaint_id', 'comments'], 'required'],
            [['account_id', 'complaint_id', 'stage', 'added_by', 'updated_by'], 'integer'],
            [['nextfollowup', 'added_on', 'updated_on'], 'safe'],
            [['comments'], 'string', 'max' => 255],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerAccount::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['complaint_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complaint::className(), 'targetAttribute' => ['complaint_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'complaint_id' => 'Complaint ID',
            'comments' => 'Comments',
            'nextfollowup' => 'Nextfollowup',
            'stage' => 'Stage',
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
     * Gets query for [[Complaint]].
     *
     * @return \yii\db\ActiveQuery|ComplaintQuery
     */
    public function getComplaint() {
        return $this->hasOne(Complaint::className(), ['id' => 'complaint_id']);
    }

    /**
     * {@inheritdoc}
     * @return ComplaintDetailsQuery the active query used by this AR class.
     */
    public static function find() {
        return new ComplaintDetailsQuery(get_called_class());
    }

}
