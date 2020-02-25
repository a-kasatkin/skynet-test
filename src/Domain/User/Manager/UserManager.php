<?php


namespace App\Domain\User\Manager;


use App\Domain\User\Entity\User;
use App\Domain\User\Provider\UserDataProviderInterface;

class UserManager implements UserManagerInterface
{
    /**
     * @var UserDataProviderInterface
     */
    private $userDataProvider;

    public function __construct(UserDataProviderInterface $userDataProvider)
    {
        $this->userDataProvider = $userDataProvider;
    }

    /**
     * @inheritDoc
     */
    public function getUserById(int $id): ?User
    {
        return $this->userDataProvider->fetchUserById($id);
    }
}