<?php


namespace VendingMachine\Machine\Items\Domain;


use VendingMachine\Shared\Domain\ValueObject\IntValueObject;

final class ItemStock extends IntValueObject
{
    public function increment(int $amount): self
    {
        return new self($this->value + $amount);
    }

    public function reduceOne(): self
    {
        return new self($this->value - 1);
    }

    public function isEmpty(): bool
    {
        return $this->value === 0;
    }
}
