<?php


namespace VendingMachine\Machine\User\Domain;


use VendingMachine\Shared\Domain\Collection;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;

final class UserCoins extends Collection
{
    protected function type(): string
    {
        return CoinValueObject::class;
    }

    public function add(CoinValueObject $coin): self
    {
        return new self([...$this->items(),$coin]);
    }

    public function toPrimitives(): array
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
