<?php


namespace VendingMachine\Machine\Items\Infrastructure;


use VendingMachine\Machine\Items\Domain\Item;
use VendingMachine\Machine\Items\Domain\ItemId;
use VendingMachine\Machine\Items\Domain\ItemName;
use VendingMachine\Machine\Items\Domain\ItemRepository;
use VendingMachine\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineItemsRepository extends DoctrineRepository implements ItemRepository
{

    public function save(Item $item): void
    {
        $this->persist($item);
    }

    public function search(ItemId $id): ?Item
    {
        return $this->repository(Item::class)->find($id->value());
    }

    public function searchByName(ItemName $name): ?Item
    {
        return $this->repository(Item::class)
            ->findOneBy(
                [
                    'name.value' => $name->value(),
                ]
            );
    }
}
