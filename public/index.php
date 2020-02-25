<?php

declare(strict_types=1);

/** @var Application $app */

use App\Application;

$app = require __DIR__ . '/../config/bootstrap.php';
$app->run();