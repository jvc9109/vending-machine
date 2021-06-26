<?php


namespace VendingMachine\Machine\Items\Application\Obtain;


use VendingMachine\Machine\Items\Domain\Item;
use VendingMachine\Machine\Items\Domain\ItemDoesNotExistsDomainError;
use VendingMachine\Machine\Items\Domain\ItemName;
use VendingMachine\Machine\Items\Domain\ItemRepository;

final class ItemObtainer
{


    public function __construct(
        private ItemRepository $repository
    )
    {
    }

    public function __invoke(string $itemName): Item
    {
        $item = $this->repository->searchByName(new ItemName($itemName));

        if ($item === null) {
            throw new ItemDoesNotExistsDomainError($itemName);
        }

        return $item;
    }


}
