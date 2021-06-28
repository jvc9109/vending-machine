<?php


namespace VendingMachine\Machine\Items\Application\UpdateStock;


use VendingMachine\Machine\Items\Domain\ItemFinder;
use VendingMachine\Machine\Items\Domain\ItemRepository;

final class StockUpdater
{
    private ItemFinder $finder;

    public function __construct(
        private ItemRepository $repository
    )
    {
        $this->finder = new ItemFinder($this->repository);
    }

    public function __invoke(string $id, int $stock): void
    {
        $item = $this->finder->__invoke($id);

        $item->makeStock($stock);

        $this->repository->save($item);
    }


}
