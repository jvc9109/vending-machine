<?php


namespace VendingMachine\Machine\User\Application\Find;


use VendingMachine\Shared\Domain\Bus\Query\QueryHandler;

final class GetUserQueryHandler implements QueryHandler
{

    public function __construct(
        private UserFinder $finder
    )
    {
    }

    public function __invoke(GetUserQuery $query): UserResponse
    {
        $user = $this->finder->__invoke($query->userId());

        return UserResponseConverter::fromUser($user);
    }


}
