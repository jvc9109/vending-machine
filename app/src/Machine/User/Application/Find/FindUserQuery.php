<?php


namespace VendingMachine\Machine\User\Application\Find;


use VendingMachine\Shared\Domain\Bus\Query\Query;

final class FindUserQuery implements Query
{


    public function __construct(private string $userId)
    {
    }

    public function userId(): string
    {
        return $this->userId;
    }


}
