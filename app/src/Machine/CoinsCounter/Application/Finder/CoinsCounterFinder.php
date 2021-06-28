<?php


namespace VendingMachine\Machine\CoinsCounter\Application\Finder;

use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounter;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterFinder as DomainCoinsCounterFinder;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterRepository;

final class CoinsCounterFinder
{
    private DomainCoinsCounterFinder $finder;

    public function __construct(private CoinsCounterRepository $repository)
    {
        $this->finder = new DomainCoinsCounterFinder($this->repository);
    }

    public function __invoke(string $id): CoinsCounter
    {
        return $this->finder->__invoke($id);
    }

}
