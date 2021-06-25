<?php


namespace VendingMachine\Tests\Machine\User\Application\AddCoin;


use VendingMachine\Machine\User\Application\AddCoin\AddCoinCommand;
use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Shared\Domain\ValueObject\Money\CoinValueObject;
use VendingMachine\Tests\Machine\User\Domain\UserIdMother;
use VendingMachine\Tests\Shared\Domain\RandomElementPicker;

final class AddCoinCommandMother
{
    public static function create(?UserId $userId = null, ?CoinValueObject $coin = null): AddCoinCommand
    {
        return new AddCoinCommand($userId?->value() ?? UserIdMother::create()->value(), $coin?->value() ?? RandomElementPicker::from(CoinValueObject::VALID_COINS)[0]);
    }

}
