<?php

namespace common\component;

use common\ebl\Constants;
use yii\helpers\Html;
use common\ebl\Constants as C;

class Utils {

    public static function getLabels($label, $values) {
        return !empty($label[$values]) ? $label[$values] : null;
    }

    public static function getTotalHrs($startTime, $endTime) {
        $time = "";
        if (strtotime($endTime) > strtotime($startTime)) {
            $time = strtotime($endTime) - strtotime($startTime);
        } else
        if (strtotime($startTime) > strtotime($endTime)) {
            $time = strtotime("$endTime +12 hours") - strtotime($startTime);
        }
        return date("H:i:s", $time);
    }

    public static function timeList() {
        $startTime = new \DateTime(date("Y-m-d 00:00"));
        $endTime = new \DateTime(date("Y-m-d 23:59"));
        $timeStep = 30;
        $timeArray = array();
        while ($startTime <= $endTime) {
            $timeArray[$startTime->format('H:i:') . '00'] = $startTime->format('H:i') . ':00';
            $startTime->add(new \DateInterval('PT' . $timeStep . 'M'));
        }
        $timeArray['23:59:59'] = '23:59:59';
        return $timeArray;
    }

    public static function getValuesFromArray($arr, $k) {
        if (\yii\helpers\ArrayHelper::keyExists($k, $arr)) {
            return \yii\helpers\ArrayHelper::getValue($arr, $k);
        }
        return null;
    }

    public static function calculateTax($amount, $applicable_on = "") {
        $applicable_on = $applicable_on ?: \common\ebl\Constants::TAX_APPLICABLE_PLAN;
        $taxObj = \common\models\TaxMaster::find()->where(['like', 'applicable_on', $applicable_on]);
        $tax_amount = 0;
        foreach ($taxObj->all() as $tax) {
            if ($tax->type == \common\ebl\Constants::TAX_TYPE_AMOUNT) {
                $tax_amount += $tax->value;
            } else {
                $tax_amount += $amount * ($tax->value / 100);
            }
        }
        return $tax_amount;
    }

    public static function optTransactionLabel() {
        return \yii\helpers\ArrayHelper::merge(
                        \common\ebl\Constants::TRANS_LABEL, \common\ebl\Constants::TRANSACTION_TYPE_OPT_DEBIT
        );
    }

    public static function subTransactionLabel() {
        return \yii\helpers\ArrayHelper::merge(
                        \common\ebl\Constants::TRANSACTION_TYPE_SUB_CREDIT, \common\ebl\Constants::TRANSACTION_TYPE_SUB_DEBIT
        );
    }

    public static function getBilledByLabels($current_role) {
        $role = [];
        foreach (Constants::OPERATOR_TYPE_LABEL as $u => $n) {
            if ($current_role > $u) {
                $role[$u] = $n;
            }
        }
        return $role;
    }

    public static function getStatusLabel($status) {
        switch ($status) {
            case Constants::STATUS_ACTIVE:
                return Html::tag('span', 'Active', ['class' => 'badge bg-success']);
            case Constants::STATUS_INACTIVE:
                return Html::tag('span', 'In Active', ['class' => 'badge bg-warning']);
            case Constants::STATUS_CANCELLED:
                return Html::tag('span', "Terminated", ['class' => 'badge bg-secondary']);
            case Constants::STATUS_EXPIRED:
                return Html::tag('span', "Expired", ['class' => 'badge bg-danger']);
            case Constants::STATUS_PENDING:
                return Html::tag('span', 'Pending', ['class' => 'badge bg-warning']);
            default:
                return "";
        }
    }

    static function ipnNetmaskRange($value) {
        $range = array();
        $split = explode('/', $value);
        if (!empty($split[0]) && is_scalar($split[1]) && filter_var($split[0], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $rangeStart = ip2long($split[0]) & ((-1 << (32 - (int) $split[1])));
            $rangeEnd = ip2long($split[0]) + pow(2, (32 - (int) $split[1])) - 1;

            for ($i = $rangeStart; $i <= $rangeEnd; $i++) {
                $range[] = long2ip($i);
            }
            return $range;
        } else {
            return $value;
        }
    }

    public static function bytesToGB($kbs) {
        $precision = 2;
        $base = log($kbs, 1000);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');
        $basekey = strlen(floor($base)) > 1 ? 0 : floor($base);
        return [round(pow(1024, $base - floor($base)), $precision), $suffixes[$basekey]];
    }

    public static function addDays($startDate, $day) {
        return date("Y-m-d", strtotime($startDate . "+ {$day} days"));
    }

    public static function dateDiff($startDate, $endDate, $format = "a") {
        $startDate = new \DateTime(Date("Y-m-d H:i:s", strtotime($startDate)));
        $endDate = new \DateTime(Date("Y-m-d H:i:s", strtotime($endDate)));
        return $endDate->diff($startDate)->format("%$format");
    }

    public static function getProspectSummary() {
        $d = \common\models\ProspectSubscriber::find()->defaultCondition()
                        ->select(['stages', 'count' => 'count(id)'])
                        ->groupBy('stages')->asArray()->all();
        $data = [];
        if (!empty($d)) {
            foreach ($d as $k => $v) {
                $lbl = !empty(Constants::PROSPECT_SATGES[$v['stages']]) ? Constants::PROSPECT_SATGES[$v['stages']] : '';
                $data[$lbl] = $v['count'];
            }
        }
        return $data;
    }

    public static function getProspectColorScheme() {
        return \Yii::$app->cache->getOrSet('prospect_color_scheme', function () {
                    $stages = Constants::PROSPECT_SATGES;
                    $color = Constants::PROSPECT_STAGES_COLOR_CODE;
                    $r = [];
                    foreach ($stages as $id => $name) {
                        $r[$name] = $color[$id]['class'];
                    }
                    return $r;
                });
    }

    public static function getComplaintSummary() {
        $d = \common\models\Complaint::find()->setAlias('a')->defaultCondition()
                        ->select(['category_id' => 'c.name', 'count' => 'count(a.id)'])
                        ->joinWith('category c')
                        ->andWhere(['a.stages' => C::COMPLAINT_PENDING])
                        ->groupBy('c.name')->asArray()->all();
        $data = [];
        if (!empty($d)) {
            foreach ($d as $k => $v) {
                $lbl = $v['category_id'];
                $data[$lbl] = $v['count'];
            }
        }
        return $data;
    }

    public static function getComplaintColorScheme() {
        return \Yii::$app->cache->getOrSet('complaint_color_scheme', function () {
                    $stages = Constants::COMPLAINT_SATGES;
                    $color = Constants::COMPLAINT_STAGES_COLOR_CODE;
                    $r = [];
                    foreach ($stages as $id => $name) {
                        $r[$name] = $color[$id]['class'];
                    }
                    return $r;
                });
    }

    public static function formatHeader($title) {
        return ucwords(str_replace(["-", "_"], " ", implode(' ', preg_split('/(?=[A-Z])/', $title))));
    }

    public static function formatNumber($number) {
        return number_format((float) $number, 2, '.', '');
    }

    public static function getMaxDates($date, $date2) {
        return max([$date, $date2]);
    }

    public static function Fy($date) {
        return date("m", strtotime($date)) > 3 ? (date('y', strtotime($date)) - 1) . date('y', strtotime($date)) : date('Y', strtotime($date)) . (date('y', strtotime($date)) + 1);
    }

    public static function getCharges($is_operator = 1) {

        $charge_list = $is_operator == 1 ? C::OPERATOR_CHARGE_LIST : C::CUSTOMER_CHARGE_LIST;
        $sel = $cond = [];
        foreach ($charge_list as $charge_name => $charge_items) {
            $sub_query = " sum(";
            $sub_query .= "case  when ";
            $sub_query .= ($charge_items['is_tax']) ? " tax>0 and " : " tax=0 and ";
            if (!empty($charge_items['credit'])) {
                $sub_query .= " trans_type in (" . implode(",", $charge_items['credit']) . ")  then 1 ";
            }
            if (!empty($charge_items['credit']) && !empty($charge_items['debit'])) {
                $sub_query .= " when   ";
            }
            if (!empty($charge_items['debit'])) {
                $sub_query .= "  trans_type in (" . implode(",", $charge_items['debit']) . ") then -1 ";
            }

            $sel[] = $sub_query . "  else 0 end * amount)  as {$charge_name}_amount";
            if ($charge_items['is_tax']) {
                $sel[] = $sub_query . " else 0 end * tax  )    as {$charge_name}_tax";
            }

            $cond = array_merge($cond, $charge_items['credit'], $charge_items['debit']);
        }
        return [$sel, $cond];
    }

    public static function getEndDate($date) {
        return date("Y-m-d 23:59:59", strtotime($date));
    }

    public static function randonColorHash() {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public static function setCache($key, $data) {
        \Yii::$app->cache->set($key, $data);
    }

    public static function getCache($key) {
        return \Yii::$app->cache->get($key);
    }

    public static function genCouponCode($length = 8, $prefix = "") {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ret = '';
        for ($i = 0; $i < $length; ++$i) {
            $random = str_shuffle($chars);
            $ret .= $random[0];
        }
        return $prefix . $ret;
    }

    public static function planDays() {
        $model = \common\models\PlanMaster::find()->where(['status' => Constants::STATUS_ACTIVE])
                        ->asArray()->all();
        if (!empty($model)) {
            return \yii\helpers\ArrayHelper::getColumn($model, 'days');
        }
        return [30, 60, 90, 120, 180];
    }

    public static function curl($url, $header = [], $data = "", $method = "get") {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        Curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
        }
        if (!empty($data)) {
            Curl_setopt($ch, CURLOPT_POSTFIELD, $data);
        }
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        $result = curl_exec($ch);
        Curl_close($ch);
        return $result;
    }

    public static function activePG() {
        return \Yii::$app->cache->getOrSet("active_config", function () {
                    $config = \common\models\ConfigMaster::getActiveConfig();
                    if (!empty($config[C::CONFIG_PAYMENT])) {
                        $d = [];
                        foreach ($config[C::CONFIG_PAYMENT] as $pay) {
                            $c = json_decode($pay['config'], 1);
                            $r = [
                                'id' => $pay['id'],
                                "gateway" => $pay['name'],
                                "gatewayUrl" => $c['gatewayurl'],
                                "reconcileUrl" => $c['reconcileUrl'],
                                "class" => $c['class'],
                            ];
                            $cred = array_diff($c, $r);
                            $r['meta_data'] = $cred;
                            $d[$pay['name']] = $r;
                            unset($r);
                        }
                        return $d;
                    }
                    return [];
                });
    }

    public static function deviceDataValidation($value, $length = 0, $type = "") {
        if (!empty($value)) {
            $isvalid = true;
            if (!empty($length)) {
                $isvalid = $isvalid && (strlen($value) === (int) $length);
            }

            if (!empty($type)) {
                switch ($type) {
                    case C::ATTRIBUTE_VALIDATION_NUMERIC:
                        $isvalid = $isvalid && is_numeric($value);
                        break;
                    case C::ATTRIBUTE_VALIDATION_APHANUMERIC:
                        $isvalid = $isvalid && ctype_alnum($value);
                        break;
                    case C::ATTRIBUTE_VALIDATION_HEX:
                        $isvalid = $isvalid && ctype_xdigit($value);
                        break;
                    case C::ATTRIBUTE_VALIDATION_MAC_ADDRESS:
                        $isvalid = $isvalid && (preg_match('/([a-fA-F0-9]{2}[:|\-]?){6}/', $value) == 1);
                        break;
                    case C::ATTRIBUTE_VALIDATION_APHABETS:
                        $isvalid = $isvalid && ctype_alpha($value);
                        break;
                    default:
                        $isvalid = $isvalid;
                }
            }
            return $isvalid;
        }
        return false;
    }

    public static function getMinDate($d1, $d2) {
        $d1 = new \DateTime($d1);
        $d2 = new \DateTime($d2);
        return $d1 < $d2 ? $d1 : $d2;
    }

    public static function getMaxDate($d1, $d2) {
        $d1 = new \DateTime($d1);
        $d2 = new \DateTime($d2);
        return $d1 > $d2 ? $d1 : $d2;
    }

}
