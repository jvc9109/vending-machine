<?php


namespace VendingMachine\Machine\Items\Application\Purchase;


final class PurchaseItemCommand
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
