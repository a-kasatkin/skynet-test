<?php


namespace App\Domain\Service\Manager;



use App\Domain\Service\Entity\Service;
use App\Domain\Tarif\Entity\Tarif;
use App\Domain\User\Entity\User;

interface ServiceManagerInterface
{
    /**
     * Returns service by user and id
     * @param User $user
     * @param int $id
     * @return Service|null
     */
    public function getServiceByUserAndId(User $user, int $id): ?Service;

    /**
     * Set tarif to service
     * @param Service $service
     * @param Tarif $tarif
     */
    public function setTarif(Service $service, Tarif $tarif): void;
}