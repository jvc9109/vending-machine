<?php


namespace VendingMachine\Machine\Items\Domain;


use VendingMachine\Shared\Domain\Aggregate\AggregateRoot;

final class Item extends AggregateRoot
{

    public function __construct(
        private ItemId $id,
        private ItemName $name,
        private ItemPrice $price,
        private ItemStatus $status,
        private ItemStock $stock
    )
    {
        parent::__construct();
    }

    public function purchaseItem(): void
    {
        $this->stock = $this->stock->reduceOne();

        if ($this->stock->isEmpty()) {
            $this->status = ItemStatus::outOfStock();
        }
    }

    public function id(): ItemId
    {
        return $this->id;
    }

    public function name(): ItemName
    {
        return $this->name;
    }

    public function price(): ItemPrice
    {
        return $this->price;
    }

    public function status(): ItemStatus
    {
        return $this->status;
    }

    public function stock(): ItemStock
    {
        return $this->stock;
    }


}
