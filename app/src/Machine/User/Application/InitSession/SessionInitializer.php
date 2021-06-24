<?php


namespace VendingMachine\Machine\User\Application\InitSession;


use VendingMachine\Machine\User\Domain\User;
use VendingMachine\Machine\User\Domain\UserRepository;

final class SessionInitializer
{

    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(string $userId): void
    {
        $user = User::initSession($userId);
        $this->repository->save($user);
    }


}
