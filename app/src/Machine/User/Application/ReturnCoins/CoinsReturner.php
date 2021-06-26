<?php


namespace VendingMachine\Machine\User\Application\ReturnCoins;


use VendingMachine\Machine\User\Domain\UserFinder;
use VendingMachine\Machine\User\Domain\UserId;
use VendingMachine\Machine\User\Domain\UserRepository;

final class CoinsReturner
{
    private UserFinder $finder;
    public function __construct(private UserRepository $repository)
    {
        $this->finder = new UserFinder($this->repository);
    }

    public function __invoke(string $userId): void
    {
        $id = new UserId($userId);

        $user = $this->finder->__invoke($id);

        $user->returnCoins();

        $this->repository->save($user);
    }


}
