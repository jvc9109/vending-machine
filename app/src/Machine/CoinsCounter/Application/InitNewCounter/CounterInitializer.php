<?php


namespace VendingMachine\Machine\CoinsCounter\Application\InitNewCounter;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounter;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterRepository;

final class CounterInitializer
{

    public function __construct(
        private CoinsCounterRepository $repository
    )
    {
    }

    public function __invoke(string $id, float $coinValue): void
    {
        $counter = CoinsCounter::initialize($id, $coinValue);
        $this->repository->save($counter);
    }

}
