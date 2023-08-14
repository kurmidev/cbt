<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "code_sequence".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $prefix
 * @property mixed $counter
 */
class CodeSequence extends \yii\mongodb\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function collectionName() {
        return 'code_sequence';
    }

    /**
     * {@inheritdoc}
     */
    public function attributes() {
        return [
            '_id',
            'prefix',
            'counter',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['prefix', 'counter'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            '_id' => 'ID',
            'prefix' => 'Prefix',
            'counter' => 'Counter',
        ];
    }

    public static function getSequence($prefix) {
        $model = self::findOne(['prefix' => $prefix]);
        if (!$model instanceof CodeSequence) {
            $model = new CodeSequence();
        }
        $model->prefix = $prefix;
        $model->counter += 1;
        $model->save();
        return $model->counter;
    }

}
