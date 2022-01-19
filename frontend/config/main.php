<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'Customer Relation Management System',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                //yii\bootstrap\BootstrapAsset::class => false,
                'yii\web\JqueryAsset' => [
                    'jsOptions' => ['position' => \yii\web\View::POS_HEAD],
                    //'js'=>[]
                ],
            ],
        ],     
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'region/<region_code:\w+>/submenu/<service_id:\w+>' => 'site/sub-menu',
                'region/<region_code:\w+>/menu' => 'site/region-units',
                'region/<region_code:\w+>' => 'site/region-units',
                'csf/<id:\w+[=]*>' => 'site/csf'
                //'region' => '<controller>/view?'
            ],
        ],
    ],
    'params' => $params,
];
