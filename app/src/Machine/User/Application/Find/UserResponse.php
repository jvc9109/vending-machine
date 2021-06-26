<?php


namespace VendingMachine\Machine\User\Application\Find;


use VendingMachine\Shared\Domain\Bus\Query\Response;

final class UserResponse implements Response
{


    public function __construct(
        private string $id,
        private array $coins,
        private string $type
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function coins(): array
    {
        return $this->coins;
    }

    public function type(): string
    {
        return $this->type;
    }


}
