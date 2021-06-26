<?php


namespace VendingMachine\Machine\Items\Domain;


use VendingMachine\Shared\Domain\DomainError;

final class ItemNotFoundDomainError extends DomainError
{
    public function __construct(private string $id)
    {
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf('The item with id %s was not found', $this->id);
    }
}
