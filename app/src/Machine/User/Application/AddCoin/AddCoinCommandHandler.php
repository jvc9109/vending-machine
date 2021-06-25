<?php


namespace VendingMachine\Machine\User\Application\AddCoin;


use VendingMachine\Shared\Domain\Bus\Command\CommandHandler;

final class AddCoinCommandHandler implements CommandHandler
{


    public function __construct(private CoinIncreaser $increaser)
    {
    }

    public function __invoke(AddCoinCommand $command): void
    {
        $this->increaser->__invoke();
    }


}
