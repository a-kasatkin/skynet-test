<?php


namespace App\Domain\Service\Mapper;


use App\Domain\Behavior\AssertableBehavior;
use App\Domain\Service\Entity\Service;

class ServiceMapper implements ServiceMapperInterface
{
    use AssertableBehavior;

    /**
     * @inheritDoc
     */
    public function mapToObject(array $rawData): Service
    {
        $this->assertKeyExists('ID', $rawData);
        $this->assertKeyExists('user_id', $rawData);
        $this->assertKeyExists('tarif_id', $rawData);
        $this->assertKeyExists('payday', $rawData);

        $service = new Service();
        $service->setId((int)$rawData['ID']);
        $service->setUserId((int)$rawData['user_id']);
        $service->setTarifId((int)$rawData['tarif_id']);
        $service->setPayDay(new \DateTimeImmutable($rawData['payday']));

        return $service;
    }
}