<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Сайт инициативной группы ЖК "Видный город"',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    //    'catchAll' => [
//        'site/notice',
//    ],

    'components' => [
        'session' => [
            'timeout' => 10 * 365 * 24 * 60 * 60],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'UTC',
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ms9enctPR-vtVYij7sX3KaY6h9_LJSqO898989',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'loginUrl' => ['site/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'enableSwiftMailerLogging' => false,
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'portal.tstm@yandex.ru',
                'password' => 'ramilmark',
                'port' => '465',
                'encryption' => 'ssl',

            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 3,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],

//                [
//                    'class' => 'yii\log\EmailTarget',
//                    'mailer' => 'mailer',
//                    'levels' => ['error', 'warning'],
//                    'message' => [
//                        'from' => ['portal.tstm@yandex.ru'],
//                        'to' => ['ramilka06@inbox.ru', 'ra.yumaev@m.mpgu.edu'],
//                        'subject' => 'Log message',
//                    ],
//                ],

            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => array(
                '' => 'site/index',
                '<action>' => 'site/<action>',
                'msg-view/<hash>' => 'site/msg-view',
            )
        ],
    ],
    'modules' => [
        'rbac' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/admin.php',

            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    /* 'userClassName' => 'app\models\User', */
                    'idField' => 'id',
                    'usernameField' => 'username',
                ],
            ],
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],

        'api' => [
            'class' => 'app\modules\api\Module',
        ],

        'news' => [
            'class' => 'app\modules\news\Module',
        ],

        'moderation' => [
            'class' => 'app\modules\moderation\Module',
        ],

        'jobs' => [
            'class' => 'app\modules\jobs\Module',
        ],
        'doclinks' => [
            'class' => 'app\modules\doclinks\Modules',
        ],

        'voting' => [
            'class' => 'app\modules\voting\Module',
        ],

        'sending' => [
            'class' => 'app\modules\sending\Module',
        ],

        'slider' => [
            'class' => 'app\modules\slider\Module',
        ],
    ],


    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'api/*',
            'slider/default/*',
        ]
    ],


    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl' => '@web',
                    'basePath' => '@webroot',
                    'path' => 'files/global',
                    'name' => 'Global',
                    'options' => [
                        'uploadDeny' => ['all'], // All Mimetypes не разрешено загружать
                        'uploadAllow' => ['image', 'text / plain', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'], // Mimetype `image` и` text / plain` разрешено загружать
                        'uploadOrder' => ['deny', 'allow'], // разрешен только Mimetype `image` и` text / plain`
                    ],
                ],
                // [
                //     'class' => 'mihaildev\elfinder\volume\UserPath',
                //     'path'  => 'files/user_{id}',
                //     'name'  => 'My Documents'
                // ],
                // [
                //     'path' => 'files/some',
                //     'name' => ['category' => 'my','message' => 'Some Name'] //перевод Yii::t($category, $message)
                // ],
                // [
                //     'path'   => 'files/some',
                //     'name'   => ['category' => 'my','message' => 'Some Name'], // Yii::t($category, $message)
                //     'access' => ['read' => '*', 'write' => 'UserFilesAccess'] // * - для всех, иначе проверка доступа в даааном примере все могут видет а редактировать могут пользователи только с правами UserFilesAccess
                // ]
            ],
            'watermark' => [
                'source' => __DIR__ . '/logo.png', // Path to Water mark image
                'marginRight' => 5,          // Margin right pixel
                'marginBottom' => 5,          // Margin bottom pixel
                'quality' => 95,         // JPEG image save quality
                'transparency' => 70,         // Water mark image transparency ( other than PNG )
                'targetType' => IMG_GIF | IMG_JPG | IMG_PNG | IMG_WBMP, // Target image formats ( bit-field )
                'targetMinPixel' => 200         // Target image minimum pixel size
            ]
        ]
    ],


    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

}


return $config;
