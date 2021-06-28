<?php


namespace VendingMachine\Machine\CoinsCounter\Application\FindByValue;


use VendingMachine\Machine\CoinsCounter\Application\GetAllCounters\CoinsCounterResponse;
use VendingMachine\Machine\CoinsCounter\Application\GetAllCounters\CoinsCounterResponseConverter;
use VendingMachine\Shared\Domain\Bus\Query\QueryHandler;

final class FindCoinsCounterByValueQueryHandler implements QueryHandler
{

    public function __construct(private CoinsCounterFinderByValue $finderByValue)
    {
    }

    public function __invoke(FindCoinsCounterByValueQuery $query): CoinsCounterResponse
    {
        return CoinsCounterResponseConverter::fromCounter($this->finderByValue->__invoke($query->value()));
    }

}
