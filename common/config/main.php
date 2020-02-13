<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [


        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            'viewPath' => '@common/mail',
//            'useFileTransport' => false,
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.yandex.ru',
//                'username' => 'noreply@stockaccs.com', /*noreply@stockaccs.com*/
//                'password' => 'h45eRBGBKdfks', /*h45eRBGBKdfks*/
//                'port' => '465',
//                'encryption' => 'ssl',
//            ],

//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.gmail.com',
//                'username' => 'xtzeve@gmail.com', /*noreply@stockaccs.com*/
//                'password' => '61206120', /*h45eRBGBKdfks*/
//                'port' => '465',
//                'encryption' => 'ssl',
//            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=studio_db',
            'username' => 'mysql',
            'password' => 'mysql',
            'enableSchemaCache' => false,
            'charset' => 'utf8',
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],
    ],


];