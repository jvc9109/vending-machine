<?php


namespace VendingMachine\Machine\Items\Domain;


interface ItemRepository
{
    public function save(Item $item): void;

    public function search(ItemId $id): ?Item;

    public function searchByName(ItemName $name): ?Item;
}
