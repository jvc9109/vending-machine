<?php


namespace VendingMachine\Machine\Items\Application\Create;


use VendingMachine\Shared\Domain\Bus\Command\Command;

final class CreateItemCommand implements Command
{

    public function __construct(
        private string $itemId,
        private string $itemName,
        private float $itemPrice,
        private int $stock
    )
    {
    }

    public function itemId(): string
    {
        return $this->itemId;
    }

    public function itemName(): string
    {
        return $this->itemName;
    }

    public function itemPrice(): float
    {
        return $this->itemPrice;
    }

    public function stock(): int
    {
        return $this->stock;
    }


}
