<?php


namespace VendingMachine\Machine\User\Application\InitSession;


use VendingMachine\Shared\Domain\Bus\Command\CommandHandler;

final class InitSessionCommandHandler implements CommandHandler
{

    public function __construct(private SessionInitializer $initializer)
    {
    }

    public function __invoke(InitSessionCommand $command): void
    {
        $this->initializer->__invoke($command->userId());
    }


}
