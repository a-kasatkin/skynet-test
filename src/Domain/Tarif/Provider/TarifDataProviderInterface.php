<?php


namespace App\Domain\Tarif\Provider;


use App\Domain\Service\Entity\Service;
use App\Domain\Tarif\Entity\Tarif;
use App\Domain\User\Entity\User;

interface TarifDataProviderInterface
{
    /**
     * Fetch tarif by user and service
     *
     * @param User $user
     * @param Service $service
     * @return Tarif|null
     */
    public function fetchByUserAndService(User $user, Service $service): ?Tarif;

    /**
     * Fetch tarif group by group id
     *
     * @param int $groupId
     * @return \Generator|Tarif[]
     */
    public function fetchGroupByGroupId(int $groupId): \Generator;

    /**
     * Fetch tarif by id
     *
     * @param int $id
     * @return Tarif|null
     */
    public function fetchById(int $id): ?Tarif;
}