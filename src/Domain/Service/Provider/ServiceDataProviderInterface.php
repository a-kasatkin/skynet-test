<?php


namespace App\Domain\Service\Provider;


use App\Domain\Service\Entity\Service;
use App\Domain\User\Entity\User;

interface ServiceDataProviderInterface
{
    /**
     * Fetches service data from database
     * @param User $user
     * @param int $id
     * @return Service|null
     */
    public function fetchServiceByUserAndId(User $user, int $id): ?Service;

    /**
     * Save service to database
     * @param Service $service
     */
    public function save(Service $service): void;
}