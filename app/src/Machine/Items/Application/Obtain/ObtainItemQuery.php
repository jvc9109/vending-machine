<?php


namespace VendingMachine\Machine\Items\Application\Obtain;


use VendingMachine\Shared\Domain\Bus\Query\Query;

final class ObtainItemQuery implements Query
{


    public function __construct(private string $itemName)
    {
    }

    public function itemName(): string
    {
        return $this->itemName;
    }


}
