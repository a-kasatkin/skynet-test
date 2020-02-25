<?php


namespace App\Domain\Tarif\Mapper;


use App\Domain\Service\Entity\Service;
use App\Domain\Tarif\Entity\Tarif;
use App\Domain\User\Entity\User;

interface TarifMapperInterface
{
    /**
     * Converts database raw data to object
     *
     * @param array $rawData
     * @return Tarif
     * @throws \Exception
     */
    public function mapToObject(array $rawData): Tarif;
}