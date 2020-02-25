<?php


namespace App\Domain\User\Mapper;


use App\Domain\User\Entity\User;

interface UserMapperInterface
{
    /**
     * Converts raw data from database to user object
     * @param array $rawData
     * @return User
     * @throws \Exception
     */
    public function mapToObject(array $rawData): User;
}