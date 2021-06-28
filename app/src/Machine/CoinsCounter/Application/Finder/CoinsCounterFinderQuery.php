<?php


namespace VendingMachine\Machine\CoinsCounter\Application\Finder;


use VendingMachine\Shared\Domain\Bus\Query\Query;

final class CoinsCounterFinderQuery implements Query
{


    public function __construct(private string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

}
