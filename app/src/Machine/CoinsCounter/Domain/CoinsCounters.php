<?php


namespace VendingMachine\Machine\CoinsCounter\Domain;


use VendingMachine\Shared\Domain\Collection;

final class CoinsCounters extends Collection
{

    protected function type(): string
    {
        return CoinsCounter::class;
    }
}
