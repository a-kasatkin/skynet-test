<?php

use App\Application;
use App\Domain\Service\Provider\ServicesServiceProvider;
use App\Domain\Tarif\Provider\TarifsControllerServiceProvider;
use App\Domain\Tarif\Provider\TarifsServiceProvider;
use App\Domain\User\Provider\UsersServiceProvider;
use App\Kernel\Provider\DatabaseServiceProvider;

require_once __DIR__ . '/autoload.php';


$loader = new Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../src');

$config = require __DIR__ . '/config.php';

$app = new Application($config);
$app->register(new DatabaseServiceProvider());
$app->register(new TarifsControllerServiceProvider());
$app->register(new TarifsServiceProvider());
$app->register(new UsersServiceProvider());
$app->register(new ServicesServiceProvider());

return $app;