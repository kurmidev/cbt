<?php

namespace common\component;

class ActiveMongoDataProvider extends \yii\data\ActiveDataProvider {

    public function setSort($sort) {
        if (empty($sort)) {
            $sort = [
                "attributes" => [
                    "_id" => [
                        'asc' => ['_id' => SORT_ASC],
                        'desc' => ['_id' => SORT_DESC],
                        'default' => SORT_DESC
                    ],
                    "updated_on" => [
                        'asc' => ['_id' => SORT_ASC],
                        'desc' => ['_id' => SORT_DESC],
                        'default' => SORT_DESC
                    ],
                ],
                'defaultOrder' => [
                    '_id' => SORT_DESC
                ]
            ];
        }
        parent::setSort($sort);
    }

    public function setPagination($page) {
        if (empty($page)) {
            $page = ['pageSize' => 10];
        }
        parent::setPagination($page);
    }

}
