<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "upload_documents".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $name
 * @property mixed $type
 * @property mixed $model_name
 * @property mixed $model_id
 * @property mixed $document
 * @property mixed $added_on
 * @property mixed $added_by
 * @property mixed $updated_on
 * @property mixed $updated_by
 */
class UploadDocuments extends \common\models\BaseMongoModel {

    const OPT_LOGO = 1;

    /**
     * {@inheritdoc}
     */
    public static function collectionName() {
        return 'upload_documents';
    }

    public function scenarios() {

        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['name', 'type', 'model_name', 'model_id', 'document', 'status'],
            self::SCENARIO_CONSOLE => ['name', 'type', 'model_name', 'model_id', 'document', 'status'],
            self::SCENARIO_UPDATE => ['name', 'type', 'model_name', 'model_id', 'document', 'status'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes() {
        return [
            '_id',
            'name',
            'type',
            'model_name',
            'model_id',
            'document',
            'status',
            'added_on',
            'added_by',
            'updated_on',
            'updated_by',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'type', 'model_name', 'model_id', 'document'], 'required'],
            [['added_on', 'added_by', 'updated_on', 'updated_by'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            '_id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'model_name' => 'Model Name',
            'model_id' => 'Model ID',
            'document' => 'Document',
            'added_on' => 'Added On',
            'added_by' => 'Added By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }

}
