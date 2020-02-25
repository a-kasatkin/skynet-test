<?php

require __DIR__ . '/db_cfg.php';

return [
    'db.options' => [
        'driver' => 'pdo_mysql',
        'host' => DB_HOST,
        'port' => '3306',
        'user' => DB_USER,
        'password' => DB_PASSWORD,
        'dbname' => DB_NAME,
        'charset' => 'cp1251'
    ],
];