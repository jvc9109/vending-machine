<?php


namespace VendingMachine\Machine\Items\Application\Create;


use VendingMachine\Machine\Items\Domain\Item;
use VendingMachine\Machine\Items\Domain\ItemRepository;

final class ItemCreator
{


    public function __construct(
        private ItemRepository $repository
    )
    {
    }

    public function __invoke(string $id, string $name, float $price, int $stock): void
    {
        $item = Item::create($id, $name, $price, $stock);
        $this->repository->save($item);
    }


}
