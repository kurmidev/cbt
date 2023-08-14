<?php
defined('SITE_NAME') or define('SITE_NAME', 'CABELTREE');
defined('CID_PREFIX') or define('CID_PREFIX', 'CBT');

return [
    'bootstrap' => [
        'queue', // The component registers its own console commands
    ],
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
// 'useFileTransport' to false and configure a transport
// for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        //'bootstrap' => ['queue'],
        'queue' => [
            'class' => yii\queue\redis\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,
        ]
    ],
];
//
//
////if (YII_ENV_DEV) {
//    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//            //'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*'],
//    ];
//
//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = [
//        'class' => 'yii\gii\Module',
//        //'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*'],
//        'generators' => [//here
//            'mymodel' => [// generator name
//                'class' => '\common\ebl\gii\model\Generator', // generator class
//                'templates' => [//setting for out templates
//                    'myModel' => 'common/ebl/gii/model/default',
//                ]
//            ],
//            'mongoDbModel' => [
//                'class' => 'yii\mongodb\gii\model\Generator'
//            ],
//            'rest' => [//
//                'class' => '\common\ebl\gii\rest\Generator',
//               'templates' => [
//                   'my' => 'common/ebl/gii/rest/default'
//                  ]
//               ],
//               'job' => [
//                'class' => \yii\queue\gii\Generator::class,
//            ],
//        ],
//    ];
//}


