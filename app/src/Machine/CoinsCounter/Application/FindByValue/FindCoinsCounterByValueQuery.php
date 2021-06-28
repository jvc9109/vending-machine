<?php


namespace VendingMachine\Machine\CoinsCounter\Application\FindByValue;


use VendingMachine\Shared\Domain\Bus\Query\Query;

final class FindCoinsCounterByValueQuery implements Query
{

    public function __construct(private float $value)
    {
    }

    public function value(): float
    {
        return $this->value;
    }


}
