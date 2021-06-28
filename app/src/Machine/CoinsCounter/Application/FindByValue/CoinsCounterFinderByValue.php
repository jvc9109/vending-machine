<?php


namespace VendingMachine\Machine\CoinsCounter\Application\FindByValue;


use phpDocumentor\Reflection\Types\This;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounter;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterCoinValue;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterRepository;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterFinderByValue as DomainFinderByValue;

final class CoinsCounterFinderByValue
{
    private DomainFinderByValue $finderByValue;
    public function __construct(private CoinsCounterRepository $repository)
    {
        $this->finderByValue = new DomainFinderByValue($this->repository);
    }

    public function __invoke(float $value): CoinsCounter
    {
       return $this->finderByValue->__invoke($value);
    }


}
