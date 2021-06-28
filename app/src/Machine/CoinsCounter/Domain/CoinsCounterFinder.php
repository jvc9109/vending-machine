<?php


namespace VendingMachine\Machine\CoinsCounter\Domain;


final class CoinsCounterFinder
{

    public function __construct(
        private CoinsCounterRepository $repository
    )
    {
    }

    public function __invoke(string $counterId): CoinsCounter
    {
        $counter = $this->repository->search(new CoinsCounterId($counterId));

        if ($counter === null) {
            //TODO add domain error
            throw new \Exception();
        }

        return $counter;
    }

}
