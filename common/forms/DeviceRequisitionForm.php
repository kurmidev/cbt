<?php

namespace common\forms;

use common\models\DeviceRequisition;

class DeviceRequisitionForm extends \yii\base\Model {

    public $name;
    public $company_id;
    public $description;
    public $items;

    public function scenarios() {
        return [
            DeviceRequisition::SCENARIO_CREATE => ['name', 'company_id', 'description', 'items'],
            DeviceRequisition::SCENARIO_PENDING => ['name', 'company_id', 'description', 'items'],
            DeviceRequisition::SCENARIO_CLOSED => ['name', 'company_id', 'description', 'items'],
        ];
    }

}
