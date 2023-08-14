<?php

$data = [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache'
        ],
        'formatter' => [
            'thousandSeparator' => ',',
            'currencyCode' => 'INR',
        ],
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
];
return loadConfig(".local", __DIR__, $data);
