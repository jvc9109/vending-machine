<?php


namespace VendingMachine\Machine\CoinsCounter\Application\RemoveCoinFromCounter;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterFinder;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterId;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterRepository;

final class CoinFromCounterRemover
{
    private CoinsCounterFinder $finder;

    public function __construct(private CoinsCounterRepository $repository)
    {
        $this->finder = new CoinsCounterFinder($this->repository);
    }

    public function __invoke(string $counterId): void
    {
        $counter = $this->finder->__invoke($counterId);

        $counter->decrement();

        $this->repository->save($counter);
    }


}
