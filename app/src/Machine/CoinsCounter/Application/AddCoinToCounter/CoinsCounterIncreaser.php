<?php


namespace VendingMachine\Machine\CoinsCounter\Application\AddCoinToCounter;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterCoinValue;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterRepository;

final class CoinsCounterIncreaser
{
    public function __construct(
        private CoinsCounterRepository $repository
    )
    {
    }

    public function __invoke(float $coinValue): void
    {
        $counter = $this->repository->searchByCoinValue(new CoinsCounterCoinValue($coinValue));
        if ($counter === null) {
            //TODO Add domain error type
            throw new \Exception();
        }

        $counter->increment();

        $this->repository->save($counter);
    }


}
