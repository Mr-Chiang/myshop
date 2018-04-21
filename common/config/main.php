<?php
return [
    'timeZone' => 'PRC',
    'language' => 'zh-CN',
    'defaultRoute' => 'admin',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],


        //RBAC
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],


    ],
];
