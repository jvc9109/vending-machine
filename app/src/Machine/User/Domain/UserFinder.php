<?php


namespace VendingMachine\Machine\User\Domain;

final class UserFinder
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(string $userId): User
    {
        $user = $this->repository->search(new UserId($userId));

        if ($user === null) {
            throw new UserNotFound($userId);
        }

        return $user;
    }
}
