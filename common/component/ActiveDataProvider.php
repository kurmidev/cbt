<?php

namespace common\component;

class ActiveDataProvider extends \yii\data\ActiveDataProvider {

    public function setSort($sort) {
        if (empty($sort)) {
            $sort = [
                "attributes" => [
                    "id" => [
                        'asc' => ['id' => SORT_ASC],
                        'desc' => ['id' => SORT_DESC],
                        'default' => SORT_DESC
                    ],
                    "updated_on" => [
                        'asc' => ['id' => SORT_ASC],
                        'desc' => ['id' => SORT_DESC],
                        'default' => SORT_DESC
                    ],
                ],
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ];
        }
        parent::setSort($sort);
    }

    public function setPagination($page) {
        if (empty($page)) {
            $page = ['pageSize' => 20];
        }
        parent::setPagination($page);
    }

}
