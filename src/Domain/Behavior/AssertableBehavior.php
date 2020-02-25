<?php


namespace App\Domain\Behavior;


trait AssertableBehavior
{
    /**
     * @param string $key
     * @throws \Exception
     */
    public function assertKeyExists(string $key, array $data): void
    {
        if (array_key_exists($key, $data)) {
            return;
        }

        throw new \Exception(
            sprintf("Identifier \"%s\" is not defined.", $key),
            500
        );
    }
}