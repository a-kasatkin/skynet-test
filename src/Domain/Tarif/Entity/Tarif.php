<?php


namespace App\Domain\Tarif\Entity;


class Tarif
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $title;
    /**
     * @var float
     */
    private $price;
    /**
     * @var int
     */
    private $speed;
    /**
     * @var string
     */
    private $link;
    /**
     * @var int
     */
    private $payPeriod;
    /**
     * @var int
     */
    private $tarifGroupId;
    /**
     * @var TarifGroup
     */
    private $tarifGroup;

    public function __construct(string $title, float $price, int $speed)
    {
        $this->title = $title;
        $this->price = $price;
        $this->speed = $speed;
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getSpeed(): int
    {
        return $this->speed;
    }

    /**
     * @param int $speed
     */
    public function setSpeed(int $speed): void
    {
        $this->speed = $speed;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return int
     */
    public function getPayPeriod(): int
    {
        return $this->payPeriod;
    }

    /**
     * @param int $payPeriod
     */
    public function setPayPeriod(int $payPeriod): void
    {
        $this->payPeriod = $payPeriod;
    }

    /**
     * @return int
     */
    public function getTarifGroupId(): int
    {
        return $this->tarifGroupId;
    }

    /**
     * @param int $tarifGroupId
     */
    public function setTarifGroupId(int $tarifGroupId): void
    {
        $this->tarifGroupId = $tarifGroupId;
    }

    /**
     * @return TarifGroup
     */
    public function getTarifGroup(): TarifGroup
    {
        return $this->tarifGroup;
    }

    /**
     * @param TarifGroup $tarifGroup
     */
    public function setTarifGroup(TarifGroup $tarifGroup): void
    {
        $this->tarifGroup = $tarifGroup;
    }

    public function toArray($withTarifGroup = false)
    {
        if ($withTarifGroup) {
            return [
                'title' => $this->title,
                'link' => $this->link,
                'speed' => $this->speed,
                'tarifs' => $this->tarifGroup->toArray()
            ];
        } else {
            $newPayDay = new \DateTime();
            $newPayDay->setTime(0,0,0);
            $newPayDay->add(new \DateInterval('P'.$this->payPeriod.'M'));
            $tzOffsetString = $newPayDay->format('P');
            $tzPrefix = str_replace(':', '', $tzOffsetString);
            return [
                'ID' => $this->id,
                'title' => $this->title,
                'price' => $this->price,
                'pay_period' => $this->payPeriod,
                'new_payday' => $newPayDay->getTimestamp() . $tzPrefix,
                'speed' => $this->speed,

            ];
        }
    }
}