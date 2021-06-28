<?php


namespace VendingMachine\Machine\CoinsCounter\Domain;


final class CoinsCounterFinderByValue
{

    public function __construct(private CoinsCounterRepository $repository)
    {
    }

    public function __invoke(float $value): CoinsCounter
    {
        $counter = $this->repository->searchByCoinValue(new CoinsCounterCoinValue($value));
        if ($counter === null) {
            //TODO Add domain error type
            throw new \Exception();
        }
        return $counter;
    }


}
