<?php

declare(strict_types=1);

namespace VendingMachine\Shared\Domain;


use DomainException;

abstract class DomainError extends DomainException
{
    public function __construct()
    {
        parent::__construct($this->errorMessage());
    }

    abstract protected function errorMessage(): string;

    final public function errorCode(): string
    {
        return Utils::toSnakeCase(Utils::extractClassName($this));
    }
}
