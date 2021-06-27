<?php


namespace VendingMachine\Machine\CoinsCounter\Domain;


interface CoinsCounterRepository
{

    public function save(CoinsCounter $coinsCounter): void;

    public function search(CoinsCounterId $coinsCounterId): ?CoinsCounter;

    public function searchByCoinValue(CoinsCounterCoinValue $coinValue): ?CoinsCounter;

    public function getAll(): CoinsCounters;

}
