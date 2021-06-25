<?php


namespace VendingMachine\Machine\User\Domain;


use VendingMachine\Shared\Domain\DomainError;

final class UserNotFound extends DomainError
{

    public function __construct(private string $userId)
    {
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf(
            'The session %s has expired',
            $this->userId
        );
    }
}
