<?php


namespace VendingMachine\Machine\Items\Domain;


final class ItemFinder
{
    public function __construct(private ItemRepository $repository)
    {
    }

    public function __invoke(string $id): Item
    {
        $item = $this->repository->search(new ItemId($id));

        if ($item === null) {
            throw new ItemNotFoundDomainError($id);
        }

        return $item;
    }
}
