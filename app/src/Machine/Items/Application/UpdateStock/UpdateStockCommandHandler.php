<?php


namespace VendingMachine\Machine\Items\Application\UpdateStock;


use VendingMachine\Shared\Domain\Bus\Command\CommandHandler;

final class UpdateStockCommandHandler implements CommandHandler
{

    public function __construct(private StockUpdater $stockUpdater)
    {
    }

    public function __invoke(UpdateStockCommand $command): void
    {
        $this->stockUpdater->__invoke($command->itemId(), $command->stock());
    }


}
