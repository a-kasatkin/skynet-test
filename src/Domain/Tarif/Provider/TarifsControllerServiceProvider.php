<?php


namespace App\Domain\Tarif\Provider;

use App\Application;
use App\Domain\Service\Manager\ServiceManager;
use App\Domain\Tarif\Controller\Action\GetUsersServicesTarifsAction;
use App\Domain\Tarif\Controller\Action\PutUsersServicesTarifsAction;
use App\Domain\Tarif\Manager\TarifManager;
use App\Domain\User\Manager\UserManager;
use App\Kernel\Provider\ServiceProviderInterface;

class TarifsControllerServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Application $app): void
    {
        $app[GetUsersServicesTarifsAction::class] = function ($app) {
            return new GetUsersServicesTarifsAction(
                $app[UserManager::class],
                $app[ServiceManager::class],
                $app[TarifManager::class]
            );
        };

        $app[PutUsersServicesTarifsAction::class] = function ($app) {
            return new PutUsersServicesTarifsAction(
                $app[UserManager::class],
                $app[ServiceManager::class],
                $app[TarifManager::class]
            );
        };

        //This collection is for invokable controllers or actions
        $app->extend('controllers_collection', function (array $controllers, $app) {
            return array_merge(
                $controllers,
                [
                    GetUsersServicesTarifsAction::class => $app[GetUsersServicesTarifsAction::class],
                    PutUsersServicesTarifsAction::class => $app[PutUsersServicesTarifsAction::class],
                ]
            );
        });
    }
}
