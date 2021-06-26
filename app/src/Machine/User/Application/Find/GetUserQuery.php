<?php


namespace VendingMachine\Machine\User\Application\Find;


use VendingMachine\Shared\Domain\Bus\Query\Query;

final class GetUserQuery implements Query
{


    public function __construct(private string $userId)
    {
    }

    public function userId(): string
    {
        return $this->userId;
    }


}
