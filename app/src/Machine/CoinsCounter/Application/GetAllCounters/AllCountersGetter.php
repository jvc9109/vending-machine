<?php


namespace VendingMachine\Machine\CoinsCounter\Application\GetAllCounters;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterRepository;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounters;

final class AllCountersGetter
{

    public function __construct(
        private CoinsCounterRepository $repository
    )
    {
    }

    public function __invoke(): CoinsCounters
    {
        return $this->repository->getAll();
    }


}
