<?php


namespace App\Domain\User\Provider;


use App\Domain\User\Entity\User;

interface UserDataProviderInterface
{
    /**
     * Fetches user object from database
     * @param int $id
     * @return User|null
     */
    public function fetchUserById(int $id): ?User;
}