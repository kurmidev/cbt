<?php

defined('SITE_NAME') or define('SITE_NAME', 'CABELTREE');
defined('CURRENCY') or define('CURRENCY', 'INR');
defined('OPERATOR_RECONCILIATION') or define('OPERATOR_RECONCILIATION', TRUE);
defined('SUBSCRIBER_RECONCILIATION') or define('SUBSCRIBER_RECONCILIATION', TRUE);
defined('SINGLE_COMPLAINT') or define('SINGLE_COMPLAINT', TRUE);
defined('OPT_RECONCILLATION') or define('OPT_RECONCILLATION', TRUE);
defined('OPT_BOUNCE_CHARGES') or define('OPT_BOUNCE_CHARGES', TRUE);
defined('BOUNCE_CHARGES') or define('BOUNCE_CHARGES', 500);

function loadConfig($prefix, $dir, $extraConfig = []) {
    $fileList = \yii\helpers\FileHelper::findFiles($dir, ['only' => ['*' . $prefix . '.php']]);
    $config = $extraConfig;

    if (!empty($fileList)) {
        $i = 0;
        foreach ($fileList as $filename) {
            $result = require($filename);
            foreach ($result as $key => $values) {
                if (\yii\helpers\ArrayHelper::keyExists($key, $config)) {
                    $config[$key] = \yii\helpers\ArrayHelper::merge($values, $config[$key]);
                } else {
                    $config[$key] = $values;
                }
            }

            $i++;
        }
    }
    return $config;
}
