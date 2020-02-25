<?php


namespace App\Domain\Service\Provider;


use App\Application;
use App\Domain\Service\Manager\ServiceManager;
use App\Domain\Service\Mapper\ServiceMapper;
use App\Kernel\Provider\ServiceProviderInterface;

class ServicesServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Application $app): void
    {
        $app[ServiceMapper::class] = function ($app) {
            return new ServiceMapper();
        };

        $app[ServiceDataProvider::class] = function ($app) {
            return new ServiceDataProvider(
                $app['db'],
                $app[ServiceMapper::class]
            );
        };

        $app[ServiceManager::class] = function ($app) {
            return new ServiceManager($app[ServiceDataProvider::class]);
        };
    }
}