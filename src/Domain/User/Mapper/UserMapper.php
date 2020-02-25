<?php


namespace App\Domain\User\Mapper;


use App\Domain\Behavior\AssertableBehavior;
use App\Domain\User\Entity\User;

class UserMapper implements UserMapperInterface
{
    use AssertableBehavior;

    /**
     * @inheritDoc
     */
    public function mapToObject(array $rawData): User
    {
        $this->assertKeyExists('name_last', $rawData);
        $this->assertKeyExists('name_first', $rawData);
        $this->assertKeyExists('login', $rawData);

        $user = new User($rawData['name_first'], $rawData['name_last']);
        $user->setLogin($rawData['login']);

        if (array_key_exists('ID', $rawData)) {
            $user->setId((int)$rawData['ID']);
        }

        return $user;
    }
}