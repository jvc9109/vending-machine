<?php


namespace VendingMachine\Machine\User\Application\AddCoin;


use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Machine\User\Domain\UserNotFound;
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
        $user = $this->repository->search(new UserId($userId));

        if ($user === null) {
            throw new UserNotFound($userId);
        }

        $user->insertCoin($value);

        $this->repository->save($user);

    }

}
