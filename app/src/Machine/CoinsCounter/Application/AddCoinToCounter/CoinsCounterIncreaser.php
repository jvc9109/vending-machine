<?php


namespace VendingMachine\Machine\CoinsCounter\Application\AddCoinToCounter;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterFinderByValue;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterRepository;

final class CoinsCounterIncreaser
{
    private CoinsCounterFinderByValue $finderByValue;

    public function __construct(private CoinsCounterRepository $repository)
    {
        $this->finderByValue = new CoinsCounterFinderByValue($this->repository);
    }

    public function __invoke(float $coinValue): void
    {
        $counter = $this->finderByValue->__invoke($coinValue);

        $counter->increment();

        $this->repository->save($counter);
    }


}
