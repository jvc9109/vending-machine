<?php


namespace VendingMachine\Machine\User\Application\AddCoin;


use VendingMachine\Machine\User\Domain\UserFinder;
use VendingMachine\Machine\User\Domain\UserRepository;

final class CoinIncreaser
{
    private UserFinder $finder;

    public function __construct(
        private UserRepository $repository
    )
    {
        $this->finder = new UserFinder($this->repository);
    }

    public function __invoke(string $userId, float $value): void
    {
        $user = $this->finder->__invoke($userId);

        $user->insertCoin($value);
        $this->repository->save($user);

    }

}
