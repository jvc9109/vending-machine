<?php


namespace VendingMachine\Machine\Items\Application\Purchase;


use VendingMachine\Shared\Domain\Bus\Command\CommandHandler;

final class PurchaseItemCommandHandler implements CommandHandler
{
    public function __construct(
        private ItemPurchaser $purchaser
    )
    {
    }

    public function __invoke(PurchaseItemCommand $command): void
    {
        $this->purchaser->__invoke(
            $command->itemId(),
            $command->userId()
        );
    }


}
