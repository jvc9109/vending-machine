<?php


namespace VendingMachine\Machine\User\Application\ReturnCoins;


use VendingMachine\Shared\Domain\Bus\Command\CommandHandler;

final class ReturnCoinsCommandHandler implements CommandHandler
{


    public function __construct(private CoinsReturner $returner)
    {
    }

    public function __invoke(ReturnCoinsCommand $command): void
    {
        $this->returner->__invoke($command->userId());
    }


}
