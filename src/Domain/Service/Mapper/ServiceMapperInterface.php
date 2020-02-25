<?php


namespace App\Domain\Service\Mapper;


use App\Domain\Service\Entity\Service;

interface ServiceMapperInterface
{
    /**
     * Converts raw data from database to service object
     * @param array $rawData
     * @return Service
     * @throws \Exception
     */
    public function mapToObject(array $rawData): Service;
}