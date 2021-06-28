<?php


namespace VendingMachine\Machine\CoinsCounter\Application\RefillCoins;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterFinder;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterRepository;

final class CoinsRefiller
{
    private CoinsCounterFinder $finder;

    public function __construct(
        private CoinsCounterRepository $repository
    )
    {
        $this->finder = new CoinsCounterFinder($this->repository);
    }

    public function __invoke(string $id, int $amount): void
    {
        $counter = $this->finder->__invoke($id);

        $counter->refill($amount);

        $this->repository->save($counter);
    }
}
