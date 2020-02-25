<?php


namespace App\Domain\Tarif\Mapper;


use App\Domain\Behavior\AssertableBehavior;
use App\Domain\Tarif\Entity\Tarif;
use App\Domain\Tarif\Entity\TarifGroup;

class TarifMapper implements TarifMapperInterface
{
    use AssertableBehavior;

    /**
     * @inheritDoc
     */
    public function mapToObject(array $rawData): Tarif
    {
//        $this->assertKeyExists('title', $rawData);
        $this->assertKeyExists('price', $rawData);
        $this->assertKeyExists('speed', $rawData);
        $this->assertKeyExists('pay_period', $rawData);
        $this->assertKeyExists('tarif_group_id', $rawData);
        $this->assertKeyExists('link', $rawData);

        $tarif = new Tarif(
            iconv('CP1251', 'UTF-8', $rawData['title']),
            (float)$rawData['price'],
            (int)$rawData['speed']
        );

        if (array_key_exists('ID', $rawData)) {
            $tarif->setId((int)$rawData['ID']);
        }

        $tarif->setPayPeriod((int)$rawData['pay_period']);
        $tarif->setTarifGroupId((int)$rawData['tarif_group_id']);
        $tarif->setLink($rawData['link']);

        if (array_key_exists('tarifs', $rawData)) {
            $tarifGroup = new TarifGroup($tarif->getTarifGroupId());

            foreach ($rawData['tarifs'] as $item) {
                $tarifGroup->addTarif($this->mapToObject($item));
            }

            $tarif->setTarifGroup($tarifGroup);
        }

        return $tarif;
    }
}