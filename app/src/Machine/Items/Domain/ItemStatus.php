<?php


namespace VendingMachine\Machine\Items\Domain;


use VendingMachine\Shared\Domain\ValueObject\Enum;

/**
 * @method static ItemStatus available()
 * @method static ItemStatus outOfStock()
 * @method static ItemStatus deleted()
 */
final class ItemStatus extends Enum
{
    private const AVAILABLE    = 1;
    private const OUT_OF_STOCK = 0;
    private const DELETED      = 2;

    protected function throwExceptionForInvalidValue($value)
    {
        throw new InvalidItemStatusDomainError($value);
    }
}
