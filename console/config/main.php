<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/params.php'
);

$conf = [
    'id' => 'ims-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User', // class that implements IdentityInterface
            'enableSession' => true,
        //'enableAutoLogin' => false,
        //'enableAutoLogin' => true,
        ],
        'session' => [
            'class' => 'yii\web\Session'
        ],
    ],
    'params' => $params,
];
//print_R($config);

return loadConfig('main.local', __DIR__, $conf);
