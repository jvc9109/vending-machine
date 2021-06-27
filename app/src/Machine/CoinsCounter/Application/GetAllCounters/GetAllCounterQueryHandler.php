<?php


namespace VendingMachine\Machine\CoinsCounter\Application\GetAllCounters;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounter;
use VendingMachine\Shared\Domain\Bus\Query\QueryHandler;
use function Lambdish\Phunctional\map;

final class GetAllCounterQueryHandler implements QueryHandler
{


    public function __construct(private AllCountersGetter $countersGetter)
    {
    }

    public function __invoke(GetAllCountersQuery $query): CoinsCountersResponse
    {
        $counters = $this->countersGetter->__invoke();
        return new CoinsCountersResponse(
            map(
                fn(CoinsCounter $counter): CoinsCounterResponse => CoinsCounterResponseConverter::fromCounter($counter),
                $counters
            )
        );
    }


}
