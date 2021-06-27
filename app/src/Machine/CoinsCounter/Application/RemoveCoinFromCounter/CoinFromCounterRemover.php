<?php


namespace VendingMachine\Machine\CoinsCounter\Application\RemoveCoinFromCounter;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterId;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterRepository;

final class CoinFromCounterRemover
{


    public function __construct(private CoinsCounterRepository $repository)
    {
    }

    public function __invoke(string $counterId): void
    {
        $counter = $this->repository->search(new CoinsCounterId($counterId));

        if ($counter === null) {
            //TODO add domain error
            throw new \Exception();
        }

        $counter->decrement();

        $this->repository->save($counter);
    }


}
