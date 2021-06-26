<?php


namespace VendingMachine\Tests\Machine\Item\Domain;


use VendingMachine\Machine\Items\Domain\ItemId;
use VendingMachine\Tests\Shared\Domain\UuidMother;

final class ItemIdMother
{
    public static function create(?string $value = null): ItemId
    {
        return new ItemId($value ?? UuidMother::create());
    }
}
