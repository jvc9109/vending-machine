<?php


namespace VendingMachine\Machine\User\Domain;


use VendingMachine\Shared\Domain\ValueObject\Money\CoinsCollection;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;

final class UserCoins extends CoinsCollection
{
    public function add(CoinValueObject $coin): self
    {
        return new self([...$this->items(),$coin]);
    }
}
