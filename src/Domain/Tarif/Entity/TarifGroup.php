<?php


namespace App\Domain\Tarif\Entity;


class TarifGroup
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var Tarif[]
     */
    private $tarifs;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->tarifs = [];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Tarif[]
     */
    public function getTarifs(): array
    {
        return $this->tarifs;
    }

    /**
     * @param Tarif[] $tarifs
     */
    public function setTarifs(array $tarifs): void
    {
        $this->tarifs = $tarifs;
    }

    /**
     * @param Tarif $tarif
     */
    public function addTarif(Tarif $tarif): void
    {
        $this->tarifs[] = $tarif;
    }

    public function toArray()
    {
        $data = [];

        foreach ($this->tarifs as $tarif) {
            $data[] = $tarif->toArray();
        }

        return $data;
    }
}