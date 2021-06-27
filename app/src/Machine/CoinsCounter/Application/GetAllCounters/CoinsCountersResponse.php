<?php


namespace VendingMachine\Machine\CoinsCounter\Application\GetAllCounters;


use VendingMachine\Shared\Domain\Bus\Query\Response;
use VendingMachine\Shared\Domain\Collection;

final class CoinsCountersResponse extends Collection implements Response
{

    protected function type(): string
    {
        return CoinsCounterResponse::class;
    }
}
