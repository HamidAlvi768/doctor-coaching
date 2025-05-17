<?php

use app\components\ManualCache;
use yii\web\Response;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'session' => [
            'class' => 'yii\web\DbSession',
            'sessionTable' => 'session', // Default is 'session'
            'sessionTable' => 'login_session',
            'timeout' => 86400,
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'DFM2O4MQiZVRz1LjzknIiHpilOY3WTUT',
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
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                'scheme' => 'smtps',
                'host' => 'mail.leightonbuzzardairportcabs.co.uk', // SMTP server
                'username' => 'twenty47logistics@leightonbuzzardairportcabs.co.uk',
                'password' => 'twenty47logistics',
                'port' => '465',
                'encryption' => 'tsl',
            ],
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
            'rules' => [],
        ],

    ],
    'params' => $params,
    // Add CSRF token validation logic
    'on beforeRequest' => function ($event) {
        $app = Yii::$app;

        if (!Yii::$app->user->isGuest) {
            ManualCache::processStudentRemainingCache();
        }

        // Only check CSRF for POST requests where validation is enabled
        if ($app->request->isPost && $app->request->enableCsrfValidation) {
            $csrfTokenFromRequest = $app->request->post($app->request->csrfParam);
            $validCsrfToken = $app->request->validateCsrfToken();

            if (!$validCsrfToken) {
                // Log the issue for debugging
                Yii::warning('Invalid or missing CSRF token detected.', __METHOD__);

                // If AJAX request, return a JSON response to trigger refresh
                if ($app->request->isAjax) {
                    $app->response->format = Response::FORMAT_JSON;
                    $app->response->data = [
                        'success' => false,
                        'message' => 'CSRF token validation failed. Please refresh the page.',
                        'refresh' => true,
                    ];
                    $app->end();
                } else {
                    // For non-AJAX, set a flag to inject refresh script in the response
                    $app->response->headers->set('X-CSRF-Invalid', 'true');
                    $app->session->setFlash('warning', 'CSRF token validation failed. The page will refresh.');
                }
            }
        }
    },
    'timeZone' => 'Asia/Karachi',
];

// if (YII_ENV_DEV) {
//     // configuration adjustments for 'dev' environment
//     $config['bootstrap'][] = 'debug';
//     $config['modules']['debug'] = [
//         'class' => 'yii\debug\Module',
//         // uncomment the following to add your IP if you are not connecting from localhost.
//         //'allowedIPs' => ['127.0.0.1', '::1'],
//     ];

//     $config['bootstrap'][] = 'gii';
//     $config['modules']['gii'] = [
//         'class' => 'yii\gii\Module',
//         // uncomment the following to add your IP if you are not connecting from localhost.
//         //'allowedIPs' => ['127.0.0.1', '::1'],
//     ];
// }

return $config;
