<?php


namespace VendingMachine\Machine\Items\Application\Purchase;


use VendingMachine\Shared\Domain\Bus\Command\Command;

final class PurchaseItemCommand implements Command
{


    public function __construct(
        private $itemId,
        private $userId
    )
    {
    }

    public function itemId()
    {
        return $this->itemId;
    }

    public function userId()
    {
        return $this->userId;
    }

}
