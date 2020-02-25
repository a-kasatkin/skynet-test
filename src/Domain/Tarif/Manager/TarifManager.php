<?php


namespace App\Domain\Tarif\Manager;


use App\Domain\Service\Entity\Service;
use App\Domain\Tarif\Entity\Tarif;
use App\Domain\Tarif\Provider\TarifDataProviderInterface;
use App\Domain\User\Entity\User;

class TarifManager implements TarifManagerInterface
{
    /**
     * @var TarifDataProviderInterface
     */
    private $tarifDataProvider;

    public function __construct(TarifDataProviderInterface $tarifDataProvider)
    {
        $this->tarifDataProvider = $tarifDataProvider;
    }

    /**
     * @inheritDoc
     */
    public function getTarifByUserAndService(
        User $user,
        Service $service
    ): ?Tarif {
        return $this->tarifDataProvider->fetchByUserAndService($user, $service);
    }

    /**
     * @inheritDoc
     */
    public function getTarifById(int $id): ?Tarif
    {
        return $this->tarifDataProvider->fetchById($id);
    }
}