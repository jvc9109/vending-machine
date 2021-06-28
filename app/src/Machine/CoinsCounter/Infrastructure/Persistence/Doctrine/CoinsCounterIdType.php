<?php


namespace VendingMachine\Machine\CoinsCounter\Infrastructure\Persistence\Doctrine;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterId;
use VendingMachine\Shared\Infrastructure\Persistence\Doctrine\Mappings\UuidType;

final class CoinsCounterIdType extends UuidType
{

    protected function typeClassName(): string
    {
        return CoinsCounterId::class;
    }
}
