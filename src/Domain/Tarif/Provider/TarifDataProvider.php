<?php


namespace App\Domain\Tarif\Provider;


use App\Domain\Service\Entity\Service;
use App\Domain\Tarif\Entity\Tarif;
use App\Domain\Tarif\Entity\TarifGroup;
use App\Domain\Tarif\Mapper\TarifMapperInterface;
use App\Domain\User\Entity\User;

class TarifDataProvider implements TarifDataProviderInterface
{
    /**
     * @var \PDO
     */
    private $db;
    /**
     * @var TarifMapperInterface
     */
    private $tarifMapper;

    public function __construct(\PDO $db, TarifMapperInterface $tarifMapper)
    {
        $this->db = $db;
        $this->tarifMapper = $tarifMapper;
    }

    /**
     * @inheritDoc
     */
    public function fetchByUserAndService(User $user, Service $service): ?Tarif
    {
        $sql =<<<SQL
SELECT t.* FROM tarifs t
JOIN services s ON t.ID = s.tarif_id
WHERE s.ID = :serviceId AND s.user_id = :userId
SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':serviceId', $service->getId(), \PDO::PARAM_INT);
        $stmt->bindValue(':userId', $user->getId(), \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        $tarif = $this->tarifMapper->mapToObject($result);
        $this->addTarifGroup($tarif);

        return $tarif;
    }

    /**
     * @inheritDoc
     */
    public function fetchGroupByGroupId(int $groupId): \Generator
    {
        $sql =<<<SQL
SELECT * FROM tarifs
WHERE tarif_group_id = :id
SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $groupId, \PDO::PARAM_INT);
        $stmt->execute();

        while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            yield $this->tarifMapper->mapToObject($result);
        }
    }

    /**
     * @inheritDoc
     */
    public function fetchById(int $id): ?Tarif
    {
        $sql =<<<SQL
SELECT * FROM tarifs
WHERE ID = :id
SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        $tarif = $this->tarifMapper->mapToObject($result);
        $this->addTarifGroup($tarif);

        return $tarif;
    }

    /**
     * @param Tarif $tarif
     */
    private function addTarifGroup(Tarif $tarif): void
    {
        $group = $this->fetchGroupByGroupId($tarif->getTarifGroupId());

        if ($group !== null) {
            $tarifGroup = new TarifGroup($tarif->getTarifGroupId());
            foreach ($group as $item) {
                $tarifGroup->addTarif($item);
            }

            $tarif->setTarifGroup($tarifGroup);
        }
    }
}