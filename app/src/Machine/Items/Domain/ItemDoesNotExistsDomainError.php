<?php


namespace VendingMachine\Machine\Items\Domain;


use VendingMachine\Shared\Domain\DomainError;

final class ItemDoesNotExistsDomainError extends DomainError
{

    public function __construct(private string $itemName)
    {
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf('The item with Name %s does not exists', $this->itemName);
    }
}
