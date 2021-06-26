<?php


namespace VendingMachine\Tests\Machine\User\Application\ReturnCoins;


use VendingMachine\Machine\User\Application\ReturnCoins\ReturnCoinsCommand;
use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Tests\Machine\User\Domain\UserIdMother;

final class ReturnCoinsCommandMother
{
    public static function create(?UserId $id = null): ReturnCoinsCommand
    {
        return new ReturnCoinsCommand($id?->value() ?? UserIdMother::create()->value());
    }

}
