<?php


namespace VendingMachine\Machine\Items\Application\Create;


use VendingMachine\Shared\Domain\Bus\Command\CommandHandler;

final class CreateItemCommandHandler implements CommandHandler
{

    public function __construct(
        private ItemCreator $creator
    )
    {
    }

    public function __invoke(CreateItemCommand $command): void
    {
        $this->creator->__invoke(
            $command->itemId(),
            $command->itemName(),
            $command->itemPrice(),
            $command->stock()
        );
    }


}
