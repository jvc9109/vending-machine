<?php


namespace VendingMachine\Shared\Domain\ValueObject\Money;


use VendingMachine\Shared\Domain\Collection;
use function Lambdish\Phunctional\map;

class CoinsCollection extends Collection
{
    protected function type(): string
    {
        return CoinValueObject::class;
    }

    final public function toPrimitives(): array
    {
        return map(fn(CoinValueObject $coin) => $coin->value(), $this->items());
    }
}
