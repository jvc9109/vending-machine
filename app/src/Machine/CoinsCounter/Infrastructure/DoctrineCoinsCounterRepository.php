<?php


namespace VendingMachine\Machine\CoinsCounter\Infrastructure;


use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounter;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterCoinValue;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterId;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounterRepository;
use VendingMachine\Machine\CoinsCounter\Domain\CoinsCounters;
use VendingMachine\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineCoinsCounterRepository extends DoctrineRepository implements CoinsCounterRepository
{

    public function save(CoinsCounter $coinsCounter): void
    {
        $this->persist($coinsCounter);
    }

    public function search(CoinsCounterId $coinsCounterId): ?CoinsCounter
    {
        return $this->repository(CoinsCounter::class)->find($coinsCounterId->value());
    }

    public function searchByCoinValue(CoinsCounterCoinValue $coinValue): ?CoinsCounter
    {
        return $this->repository(CoinsCounter::class)
            ->findOneBy(
                [
                    'coin.value' => $coinValue->value(),
                ]
            );
    }

    public function getAll(): CoinsCounters
    {
        return new CoinsCounters($this->repository(CoinsCounter::class)->findAll());
    }
}
