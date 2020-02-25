<?php


namespace App\Domain\Tarif\Manager;


use App\Domain\Service\Entity\Service;
use App\Domain\Tarif\Entity\Tarif;
use App\Domain\User\Entity\User;

interface TarifManagerInterface
{
    /**
     * Returns tarif object by user and service
     * @param User $user
     * @param Service $service
     * @return Tarif|null
     */
    public function getTarifByUserAndService(User $user, Service $service): ?Tarif;

    /**
     * Returns tarif object by id
     *
     * @param int $id
     * @return Tarif|null
     */
    public function getTarifById(int $id): ?Tarif;
}