<?php


namespace App\Domain\Service\Entity;


use App\Domain\Tarif\Entity\Tarif;
use App\Domain\User\Entity\User;

class Service
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $userId;
    /**
     * @var int
     */
    private $tarifId;
    /**
     * @var \DateTimeInterface
     */
    private $payDay;

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
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getTarifId(): int
    {
        return $this->tarifId;
    }

    /**
     * @param int $tarifId
     */
    public function setTarifId(int $tarifId): void
    {
        $this->tarifId = $tarifId;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getPayDay(): \DateTimeInterface
    {
        return $this->payDay;
    }

    /**
     * @param \DateTimeInterface $payDay
     */
    public function setPayDay(\DateTimeInterface $payDay): void
    {
        $this->payDay = $payDay;
    }
}