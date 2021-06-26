<?php


namespace VendingMachine\Shared\Domain\ValueObject\Money;


use VendingMachine\Shared\Domain\Collection;

class CoinsCollection extends Collection
{
    protected function type(): string
    {
        return CoinValueObject::class;
    }

    final public function add(CoinValueObject $coin): self
    {
        return new self([...$this->items(),$coin]);
    }

    final public function toPrimitives(): array
    {
        $coins = $this->items();
        $primitives = [];

        /** @var CoinValueObject $coin */
        foreach ($coins as $coin){
            $primitives[] = $coin->value();
        }

        return $primitives;
    }
}
