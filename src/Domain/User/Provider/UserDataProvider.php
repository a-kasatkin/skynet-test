<?php


namespace App\Domain\User\Provider;


use App\Domain\User\Entity\User;
use App\Domain\User\Mapper\UserMapperInterface;

class UserDataProvider implements UserDataProviderInterface
{
    /**
     * @var \PDO
     */
    private $db;
    /**
     * @var UserMapperInterface
     */
    private $userMapper;

    public function __construct(\PDO $db, UserMapperInterface $userMapper)
    {
        $this->db = $db;
        $this->userMapper = $userMapper;
    }

    /**
     * @inheritDoc
     */
    public function fetchUserById(int $id): ?User
    {
        $sql =<<<SQL
SELECT * FROM users
WHERE id = :id
SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        return $this->userMapper->mapToObject($result);
    }
}