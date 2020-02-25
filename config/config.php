<?php

$params = [];

return array_merge(
    $params,
    require __DIR__ . '/db/connection.php',
    require __DIR__ . '/router/routes.php'
);