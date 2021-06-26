<?php


namespace VendingMachine\Machine\User\Application\Find;


use VendingMachine\Machine\User\Domain\User;

final class UserResponseConverter
{
    public static function fromUser(User $user): UserResponse
    {
        return new UserResponse(
            $user->id()->value(),
            $user->coins()->toPrimitives(),
            $user->type()->value()
        );
    }


}
