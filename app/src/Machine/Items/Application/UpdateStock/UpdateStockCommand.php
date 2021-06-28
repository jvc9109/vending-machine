<?php


namespace VendingMachine\Machine\Items\Application\UpdateStock;


use VendingMachine\Shared\Domain\Bus\Command\Command;

final class UpdateStockCommand implements Command
{


    public function __construct(
        private string $itemId,
        private int $stock
    )
    {
    }

    public function itemId(): string
    {
        return $this->itemId;
    }

    public function stock(): int
    {
        return $this->stock;
    }


}
