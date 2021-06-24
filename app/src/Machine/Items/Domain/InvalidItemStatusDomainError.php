<?php


namespace VendingMachine\Machine\Items\Domain;


use VendingMachine\Shared\Domain\DomainError;

final class InvalidItemStatusDomainError extends DomainError
{

    public function __construct(private int $status)
    {
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf('The status %d is not valid', $this->status);
    }
}
