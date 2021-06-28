<?php


namespace VendingMachine\Machine\CoinsCounter\Application\RefillCoins;


use VendingMachine\Shared\Domain\Bus\Command\CommandHandler;

final class RefillCoinsCommandHandler implements CommandHandler
{
    public function __construct(
        private CoinsRefiller $refiller
    )
    {
    }

    public function __invoke(RefillCoinsCommand $command): void
    {
        $this->refiller->__invoke($command->counterId(), $command->amount());
    }


}
