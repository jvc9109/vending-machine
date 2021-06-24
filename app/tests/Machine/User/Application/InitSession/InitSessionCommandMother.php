<?php


namespace VendingMachine\Tests\Machine\User\Application\InitSession;


use VendingMachine\Machine\User\Application\InitSession\InitSessionCommand;
use VendingMachine\Tests\Machine\User\Domain\UserIdMother;

final class InitSessionCommandMother
{
    public static function create(
        ?string $userId = null
    ): InitSessionCommand
    {
        return new InitSessionCommand($userId ?? UserIdMother::create()->value());
    }

}
