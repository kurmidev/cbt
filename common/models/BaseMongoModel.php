<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;

class BaseMongoModel extends \yii\mongodb\ActiveRecord {

    use BaseTraits;
    use \common\ebl\ModelTraits;

    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DELETE = 'delete';
    const SCENARIO_CONSOLE = 'console';

    public function behaviors() {

        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'added_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['added_on'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'updated_on',
                ],
                'value' => date("Y-m-d H:i:s"),
            ]
        ];
    }

    /*
     * function to get the latest change done
     * @return datetime
     */

    public function getActionOn() {
        return is_null($this->updated_on) ?
                Yii::$app->formatter->asDatetime($this->added_on) :
                Yii::$app->formatter->asDatetime($this->updated_on);
    }

}
