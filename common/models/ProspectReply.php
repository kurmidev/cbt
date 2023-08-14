<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prospect_reply".
 *
 * @property int $id
 * @property int|null $prospect_id
 * @property string $remark
 * @property int $stages
 * @property int $status
 * @property int $action_assigned
 * @property string|null $action_taken
 * @property string|null $start_on
 * @property string|null $done_on
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property ProspectSubscriber $prospect
 */
class ProspectReply extends \common\models\BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'prospect_reply';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['prospect_id', 'remark', 'stages', 'status', 'action_assigned', 'action_taken', 'start_on', 'done_on', 'meta_data', 'ticketno'],
            self::SCENARIO_CONSOLE => ['prospect_id', 'remark', 'stages', 'status', 'action_assigned', 'action_taken', 'start_on', 'done_on', 'meta_data', 'ticketno'],
            self::SCENARIO_UPDATE => ['prospect_id', 'remark', 'stages', 'status', 'action_assigned', 'action_taken', 'start_on', 'done_on', 'meta_data', 'ticketno'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['prospect_id', 'stages', 'status', 'action_assigned', 'added_by', 'updated_by'], 'integer'],
            [['remark', 'stages', 'status', 'action_assigned', 'ticketno'], 'required'],
            [['start_on', 'done_on', 'added_on', 'updated_on', 'meta_data'], 'safe'],
            [['remark', 'action_taken'], 'string', 'max' => 255],
            [['prospect_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProspectSubscriber::className(), 'targetAttribute' => ['prospect_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'prospect_id' => 'Prospect ID',
            'ticketno' => 'Ticket no',
            'remark' => 'Remark',
            'stages' => 'Stages',
            'status' => 'Status',
            'action_assigned' => 'Action Assigned',
            'action_taken' => 'Action Taken',
            'start_on' => 'Start On',
            'done_on' => 'Done On',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Prospect]].
     *
     * @return \yii\db\ActiveQuery|ProspectSubscriberQuery
     */
    public function getProspect() {
        return $this->hasOne(ProspectSubscriber::className(), ['id' => 'prospect_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProspectReplyQuery the active query used by this AR class.
     */
    public static function find() {
        return new ProspectReplyQuery(get_called_class());
    }

}
