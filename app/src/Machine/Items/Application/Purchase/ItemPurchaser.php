<?php


namespace VendingMachine\Machine\Items\Application\Purchase;


use VendingMachine\Machine\Items\Domain\ItemRepository;
use VendingMachine\Shared\Domain\Bus\Event\EventBus;
use VendingMachine\Shared\Domain\Bus\Query\QueryBus;

final class ItemPurchaser
{

    public function __construct(
        private ItemRepository $repository,
        private EventBus $eventBus,
        private QueryBus $queryBus
    )
    {
    }
}
