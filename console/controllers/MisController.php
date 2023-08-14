<?php

namespace console\controllers;

use common\models\VoucherMaster;
use common\ebl\Constants as C;

class MisController extends BaseConsoleController {

    public function actionExpireVouhcer() {
        $query = VoucherMaster::find()->where(['<', 'expiry_date', date("Y-m-d")])
                ->andWhere(['OR', ['opt_wallet_id' => null], ['cus_wallet_id' => null]]);

        foreach ($query->batch() as $vouchers) {
            $voucher_ids = \yii\helpers\ArrayHelper::getColumn($vouchers, 'id');
            if (!empty($voucher_ids)) {
                VoucherMaster::updateAll(['status' => C::VOUCHER_EXPIRED, 'remark' => "Vouhcer marked expired as voucher validity end."],
                        ["id" => $voucher_ids]);
            }
        }
    }

}
