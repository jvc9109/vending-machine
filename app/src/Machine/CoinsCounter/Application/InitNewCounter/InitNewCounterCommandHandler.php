<?php


namespace VendingMachine\Machine\CoinsCounter\Application\InitNewCounter;


use VendingMachine\Shared\Domain\Bus\Command\CommandHandler;

final class InitNewCounterCommandHandler implements CommandHandler
{
    public function __construct(
        private CounterInitializer $initializer
    )
    {
    }

    public function __invoke(InitNewCounterCommand $command): void
    {
        $this->initializer->__invoke(
            $command->counterId(),
            $command->coinValue()
        );
    }


}
