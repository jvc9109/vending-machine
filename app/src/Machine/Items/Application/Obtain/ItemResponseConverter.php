<?php


namespace VendingMachine\Machine\Items\Application\Obtain;


use VendingMachine\Machine\Items\Domain\Item;

final class ItemResponseConverter
{
    public static function fromItem(Item $item): ItemResponse
    {
        return new ItemResponse(
            $item->id()->value(),
            $item->name()->value(),
            $item->price()->value(),
            $item->status()->value(),
            $item->stock()->value()
        );
    }
}
