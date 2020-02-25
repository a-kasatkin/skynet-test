<?php


namespace App\Domain\User\Manager;


use App\Domain\User\Entity\User;

interface UserManagerInterface
{
    /**
     * Returns user by id
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User;
}