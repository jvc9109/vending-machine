<?php


namespace VendingMachine\Machine\Items\Infrastructure\Persistence\Doctrine;


use VendingMachine\Machine\Items\Domain\ItemId;
use VendingMachine\Shared\Infrastructure\Persistence\Doctrine\MAppings\UuidType;

final class ItemIdType extends UuidType
{

    protected function typeClassName(): string
    {
        return ItemId::class;
    }
}
