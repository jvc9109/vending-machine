<?php


namespace VendingMachine\Machine\CoinsCounter\Application\Finder;


use VendingMachine\Machine\CoinsCounter\Application\GetAllCounters\CoinsCounterResponse;
use VendingMachine\Machine\CoinsCounter\Application\GetAllCounters\CoinsCounterResponseConverter;
use VendingMachine\Shared\Domain\Bus\Query\QueryHandler;

final class CoinsCounterFinderQueryHandler implements QueryHandler
{

    public function __construct(private CoinsCounterFinder $finder)
    {
    }

    public function __invoke(CoinsCounterFinderQuery $query): CoinsCounterResponse
    {
        return CoinsCounterResponseConverter::fromCounter($this->finder->__invoke($query->id()));
    }


}
