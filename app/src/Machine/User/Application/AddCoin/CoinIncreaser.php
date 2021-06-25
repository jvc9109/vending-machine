<?php


namespace VendingMachine\Machine\User\Application\AddCoin;


use VendingMachine\Machine\User\Domain\UserRepository;

final class CoinIncreaser
{

    public function __construct(
        private UserRepository $repository
    )
    {
    }

    public function __invoke(string $userId, float $value): void
    {
        return;
    }

}
