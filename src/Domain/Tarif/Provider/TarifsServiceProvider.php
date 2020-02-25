<?php


namespace App\Domain\Tarif\Provider;


use App\Application;
use App\Domain\Tarif\Manager\TarifManager;
use App\Domain\Tarif\Mapper\TarifMapper;
use App\Kernel\Provider\ServiceProviderInterface;

class TarifsServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Application $app): void
    {
        $app[TarifMapper::class] = function ($app) {
            return new TarifMapper();
        };

        $app[TarifDataProvider::class] = function ($app) {
            return new TarifDataProvider(
                $app['db'],
                $app[TarifMapper::class]
            );
        };

        $app[TarifManager::class] = function ($app) {
            return new TarifManager(
                $app[TarifDataProvider::class]
            );
        };
    }
}
