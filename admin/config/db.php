<?php
require_once __DIR__ . '/../../class/Config.class.php';
use Webai\Api\Config;
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.Config::DB_HOST.';dbname='.Config::DB_NAME,
    'username' => Config::DB_USER,
    'password' => Config::DB_PASS,
    'charset' => 'utf8',
];
