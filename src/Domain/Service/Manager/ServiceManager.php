<?php


namespace App\Domain\Service\Manager;


use App\Domain\Service\Entity\Service;
use App\Domain\Service\Provider\ServiceDataProviderInterface;
use App\Domain\Tarif\Entity\Tarif;
use App\Domain\User\Entity\User;

class ServiceManager implements ServiceManagerInterface
{
    /**
     * @var ServiceDataProviderInterface
     */
    private $serviceDataProvider;

    public function __construct(ServiceDataProviderInterface $serviceDataProvider)
    {
        $this->serviceDataProvider = $serviceDataProvider;
    }

    /**
     * @inheritDoc
     */
    public function getServiceByUserAndId(User $user, int $id): ?Service
    {
        return $this->serviceDataProvider->fetchServiceByUserAndId($user, $id);
    }

    /**
     * @inheritDoc
     */
    public function setTarif(Service $service, Tarif $tarif): void
    {
        $service->setTarifId($tarif->getId());
        $payDay = new \DateTime();
        $payDay->add(new \DateInterval('P'.$tarif->getPayPeriod().'M'));
        $service->setPayDay($payDay);

        $this->serviceDataProvider->save($service);
    }


}