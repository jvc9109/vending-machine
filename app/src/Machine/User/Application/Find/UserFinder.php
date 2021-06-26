<?php


namespace VendingMachine\Machine\User\Application\Find;


use VendingMachine\Machine\User\Domain\User;
use VendingMachine\Machine\User\Domain\UserRepository;
use VendingMachine\Machine\User\Domain\UserFinder as DomainUserFinder;

final class UserFinder
{
    private DomainUserFinder $finder;
    public function __construct(private UserRepository $repository)
    {
        $this->finder = new DomainUserFinder($this->repository);
    }

    public function __invoke(string $userId): User
    {
       return $this->finder->__invoke($userId);
    }


}
