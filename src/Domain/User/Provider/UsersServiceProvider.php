<?php


namespace App\Domain\User\Provider;


use App\Application;
use App\Domain\User\Manager\UserManager;
use App\Domain\User\Mapper\UserMapper;
use App\Kernel\Provider\ServiceProviderInterface;

class UsersServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Application $app): void
    {
        $app[UserMapper::class] = function ($app) {
            return new UserMapper();
        };

        $app[UserDataProvider::class] = function ($app) {
            return new UserDataProvider(
                $app['db'],
                $app[UserMapper::class]
            );
        };

        $app[UserManager::class] = function ($app) {
            return new UserManager($app[UserDataProvider::class]);
        };
    }
}