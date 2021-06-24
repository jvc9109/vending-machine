<?php


namespace VendingMachine\Machine\CoinsCounter\Domain;


use VendingMachine\Shared\Domain\ValueObject\IntValueObject;

final class CoinsCounterTotalCoins extends IntValueObject
{
    public static function initialize(): self
    {
        return new self(0);
    }

    public function increment(): self
    {
        return new self($this->value() + 1);
    }

    public function decrement(): self
    {
        return new self($this->value() - 1);
    }
}
