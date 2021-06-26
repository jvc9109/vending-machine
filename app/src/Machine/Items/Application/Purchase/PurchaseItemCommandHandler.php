<?php


namespace VendingMachine\Machine\Items\Application\Purchase;


use VendingMachine\Machine\Items\Domain\ItemRepository;
use VendingMachine\Shared\Domain\Bus\Command\CommandHandler;
use VendingMachine\Shared\Domain\Bus\Event\EventBus;
use VendingMachine\Shared\Domain\Bus\Query\QueryBus;

final class PurchaseItemCommandHandler implements CommandHandler
{
    public function __construct(
        private ItemPurchaser $purchaser
    )
    {
    }
}
