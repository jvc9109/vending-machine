<?php


namespace VendingMachine\Tests\Machine\Item\Domain;


use VendingMachine\Machine\Items\Domain\ItemStatus;

final class ItemStatusMother
{
    public static function create(?string $value = null): ItemStatus
    {
        return new ItemStatus($value ?? ItemStatus::random()->value());
    }

    public static function available(): ItemStatus
    {
        return ItemStatus::available();
    }
}
