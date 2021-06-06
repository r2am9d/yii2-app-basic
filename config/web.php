<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Yii2 App Basic',
    'timeZone' => 'Asia/Manila', // @link https://www.php.net/manual/en/timezones.php
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower',
        '@npm'   => '@vendor/npm',
        '@file' => dirname(__DIR__),
    ],
    'bootstrap' => ['log', 'maintenanceMode', 'queue'],
    'components' => [
        'maintenanceMode' => [
            'enabled' => false,
            'roles' => ['ADMIN'],
            'urls' => ['user/security/login', 'user/security/logout'],
            'route' => 'maintenance/index',
            'class' => 'brussens\maintenance\MaintenanceMode',
        ],
        'queue' => [
            'db' => 'db',
            'channel' => 'default',
            'strictJobType' => false,
            'tableName' => '{{%queue}}',
            'class' => 'yii\queue\db\Queue',
            'mutex' => 'yii\mutex\MysqlMutex',
            'as log' => 'yii\queue\LogBehavior',
            'serializer' => 'yii\queue\serializers\JsonSerializer',
        ],
        'request' => [
            // @link https://phpsolved.com/phpmyadmin-blowfish-secret-generator/
            'cookieValidationKey' => 'vwqRC-aqkssJiDsb:YoCAhyk.Ds,;nnE',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser'
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'job' => [
                'class' => 'yii\queue\gii\Generator',
            ],
            'rule' => [
                'class' => 'r2am9d\rule\gii\Generator',
            ],
        ],
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
