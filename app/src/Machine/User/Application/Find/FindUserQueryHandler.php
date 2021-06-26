<?php


namespace VendingMachine\Machine\User\Application\Find;


use VendingMachine\Shared\Domain\Bus\Query\QueryHandler;

final class FindUserQueryHandler implements QueryHandler
{

    public function __construct(
        private UserFinder $finder
    )
    {
    }

    public function __invoke(FindUserQuery $query): UserResponse
    {
        $user = $this->finder->__invoke($query->userId());

        return UserResponseConverter::fromUser($user);
    }


}
