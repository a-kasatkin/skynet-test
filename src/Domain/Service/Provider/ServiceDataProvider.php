<?php


namespace App\Domain\Service\Provider;


use App\Domain\Service\Entity\Service;
use App\Domain\Service\Mapper\ServiceMapperInterface;
use App\Domain\User\Entity\User;

class ServiceDataProvider implements ServiceDataProviderInterface
{
    /**
     * @var \PDO
     */
    private $db;
    /**
     * @var ServiceMapperInterface
     */
    private $serviceMapper;

    public function __construct(\PDO $db, ServiceMapperInterface $serviceMapper)
    {
        $this->db = $db;
        $this->serviceMapper = $serviceMapper;
    }

    /**
     * @inheritDoc
     */
    public function fetchServiceByUserAndId(User $user, int $id): ?Service
    {
        $sql =<<<SQL
SELECT * FROM services
WHERE ID = :id AND user_id = :userId;
SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->bindValue(':userId', $user->getId(), \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        return $this->serviceMapper->mapToObject($result);
    }

    /**
     * @inheritDoc
     */
    public function save(Service $service): void
    {
        $sql = sprintf(
            "UPDATE services SET tarif_id=%d, payday='%s' WHERE ID=%d AND user_id=%d",
            $service->getTarifId(),
            $service->getPayDay()->format('Y-m-d'),
            $service->getId(),
            $service->getUserId()
        );

        $this->db->exec($sql);
    }
}