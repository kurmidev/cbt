<?php

namespace common\ebl\jobs;

use common\models\OptPaymentReconsile;
use common\ebl\jobs\ReconsilationJob;

class FinalReconsilationJob extends ReconsilationJob {

    public function scenarios() {
        return [
            OptPaymentReconsile::SCENARIO_CREATE => ["receipt_no", "deposited_bank", "deposited_by", "desposited_on", 'status_int', "id", 'deposited_by_id', 'realised_on', 'realised_by_id'],
            OptPaymentReconsile::SCENARIO_MIGRATE => ["receipt_no", "realized_on", "realised_by", 'status']
        ];
    }

    public function _execute($data) {
        $this->scenario = OptPaymentReconsile::SCENARIO_MIGRATE;
        if ($this->load($data, '') && $this->validate() && $this->save()) {
            return true;
        } else {
            if (!empty($this->errors)) {
                $this->errorCnt++;
                $this->response[$this->count]["message"] = implode(" ", $this->getErrorSummary(true));
            }
        }
    }

}
